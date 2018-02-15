<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Catchment;
use app\models\Sensor;
use app\models\UploaddataForm;
use app\models\Observation;

// quick solution from https://stackoverflow.com/questions/6671183/calculate-the-center-point-of-multiple-latitude-longitude-coordinate-pairs
// should be under MIT licence
// TODO we might want to place it somewhere else (helper?) and rewrite it
/**
 * Calculate center of given coordinates
 * @param  array    $coordinates    Each array of coordinate pairs
 * @return array                    Center of coordinates
 */
function getCoordsCenter($coordinates) {
    $lats = $lons = array();
    foreach ($coordinates as $key => $value) {
        array_push($lats, $value[0]);
        array_push($lons, $value[1]);
    }
    $minlat = min($lats);
    $maxlat = max($lats);
    $minlon = min($lons);
    $maxlon = max($lons);
    $lat = $maxlat - (($maxlat - $minlat) / 2);
    $lng = $maxlon - (($maxlon - $minlon) / 2);
    return array("lat" => $lat, "lon" => $lng);
}

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'addsensor', 'uploaddata'],
                'rules' => [
                    [
                        'actions' => ['logout', 'addsensor', 'uploaddata'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionObservatory(){
        $content = null;
        $data_points = [];
        $request = Yii::$app->request;

        // parse data form post method
        $sensor_id = ArrayHelper::getValue($request, function ($request){
            return $request->post('sensor_id');
        });
        $chart_type = ArrayHelper::getValue($request, function ($request){
            return $request->post('chart_type');
        }, 'line');
        $time_span = ArrayHelper::getValue($request, function ($request){
            return $request->post('time_span');
        }, '9 months');
        $selected_location = ArrayHelper::getValue($request, function ($request){
            return $request->post('location');
        });


        if (isset($sensor_id)){
            // TODO get search parameters from user (view)
            $dataPoints = [];

            $now=strtotime("now");
            $con1 = date("Y-m-d H:i:s", strtotime("-".$time_span, $now));
            $con2 = date("Y-m-d H:i:s", $now);  // e.g.'2016-04-02 15:40:00'
            $numIntervals = 400; // where do we get this?
            $includeMinMax = true; // where do we get this?

            $results = Observation::find()->
            where(['sensor_id' => $sensor_id])->
            andWhere(['between','timestamp',$con1,$con2])->
            orderBy('timestamp ASC')->all();

            //TODO samplings from fetch_simple, this needs to be optimized
            $timePerInterval = (strtotime($con2)*1000 - strtotime($con1)*1000) / $numIntervals;
            $currTime = strtotime($con1)*1000;

            //Find start of load request in the raw dataset
            // (this should be zero with a freshly retrieved dataset but may change when zooming?)
            $currIdx = 0;
            for ($i = 0; $i < sizeof($results); $i++) {
                if (strtotime($results[$currIdx]['timestamp'])*1000 < ($currTime - $timePerInterval)) {
                    $currIdx++;
                } else {
                    break;
                }
            }

            // Calculate average/min/max while downsampling
            while ($currIdx < sizeof($results) and $currTime < strtotime($con2)*1000) {
                $numPoints = 0;
                $sum = 0;
                $min = 9007199254740992;
                $max = -9007199254740992;
                while ($currIdx < sizeof($results) and strtotime($results[$currIdx]['timestamp'])*1000 < $currTime) {
                    $sum += $results[$currIdx]['value'];
                    $min = min($min, $results[$currIdx]['value']);
                    $max = max($max, $results[$currIdx]['value']);
                    $currIdx++;
                    $numPoints++;
                }
                if ($numPoints == 0) {
                    if ($includeMinMax) {
                        array_push($dataPoints, array(
                            'x' => $currTime,
                            'avg' => null,
                            'min' => null,
                            'max' => null
                        ));
                    } else {
                        array_push($dataPoints, array(
                            'x' => $currTime,
                            'avg' => null
                        ));
                    }
                } else { // numPoints != 0
                    $avg = $sum / $numPoints;

                    if ($includeMinMax) {
                        array_push($dataPoints, array(
                            'x' => $currTime,
                            'avg' => round($avg, 2),
                            'min' => round($min, 2),
                            'max' => round($max, 2),
                        ));
                    } else {
                        array_push($dataPoints, array(
                            'x' => $currTime,
                            'avg' => round($avg,2)
                        ));
                    }
                }
                $currTime += $timePerInterval;
                $currTime = round($currTime, 2);
            }


            foreach ($dataPoints as $point) {
                array_push($data_points, array($point['x'], $point['avg']));
            }
            $sensor = Sensor::find()->where(['id' => $sensor_id])->one();
            $catchment = Catchment::find()->where(['id' => $sensor->catchmentid])->one();
            $content = array(
                'sensor' => $sensor,
                'catchment' => $catchment,
                'data_points' => json_encode($data_points),
                'time_span' => $time_span,
                'chart_type' => $chart_type
            );

            return $this->renderAjax('observatory_content',  array(
                'content' => $content
            ));

        }
        else {
            $locations = Catchment::find()->all();
            $tree_data = array();
            $markers_centers = [];
            foreach ($locations as $location) {
                $location_name = $location->getAttribute('name');
                $sensors = Sensor::find()->where(['catchmentid' => $location->id])->all();
                // show only locations with some sensors
                if (sizeof($sensors)){
                    $tree_data[$location_name] = $sensors;
                    $coordinates = [];
                    foreach ($sensors as $sensor){
                        array_push($coordinates, [$sensor->latitude,$sensor->longitude]);
                    }
                    $center = getCoordsCenter($coordinates);
                    $markers_centers[$location_name] = [$center['lat'], $center['lon']];
                }
            }

            // center map to selected location
            if (isset($selected_location)){
                $map_center = ['lat' => $markers_centers[$selected_location][0], 'lon'=>$markers_centers[$selected_location][1]];
                return $this->renderAjax('observatory',  array(
                    'tree_data' => $tree_data,
                    'map_center' => $map_center,
                ));
            }
            else {
                $map_center = getCoordsCenter($markers_centers);
            }

            $this->layout='main_nofooter.php';
            return $this->render('observatory',  array(
                'tree_data' => $tree_data,
                'map_center' => $map_center,
            ));
        }

    }

    public function actionAddsensor($locationid=null){
        $model = new Sensor;
        if (isset($locationid)){
            $model->catchmentid = $locationid;
        }
        try {
            if ($model->load($_POST) && $model->save()) {
                return $this->redirect(['/site/sensor', 'sensorid' => $model->id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }
        return $this->render('addsensor', ['model' => $model]);
    }

    public function actionSensorpopup($locationid=null){
        $locations = Catchment::find()->all();
        if (isset($locationid)){
            $location = Catchment::find()->where(['id' => $locationid])->one();
        }else{
            $location = $locations[0];
        }
        return $this->renderPartial('sensorpopup', array('locations' => $locations, 'location' => $location));
    }


    public function actionIndicators(){
        return $this->render('indicators');
    }

    public function actionSensors(){
        return $this->render('sensors');
    }

    public function actionSensor($sensorid=null){
        if (isset($sensorid)){
            $sensor = Sensor::find()->where(['id' => $sensorid])->one();
            return $this->render('sensor_sensor', array('sensor' => $sensor));
        }else{
            return $this->render('sensor_sensor', array('sensor' => null));
        }
    }

    public function actionMaps($sensorid=null){
        if (isset($sensorid)){
            $sensor = Sensor::find()->where(['id' => $sensorid])->one();
            return $this->render('sensor_maps', array('sensor' => $sensor));
        }else{
            return $this->render('sensor_maps', array('sensor' => null));
        }
    }

    public function actionRiverflow($sensorid=null){
        if (isset($sensorid)){
            $sensor = Sensor::find()->where(['id' => $sensorid])->one();
            return $this->render('sensor_riverflow', array('sensor' => $sensor));
        }else{
            return $this->render('sensor_riverflow', array('sensor' => null));
        }
    }

    public function actionRainfall($sensorid=null){
        if (isset($sensorid)){
            $sensor = Sensor::find()->where(['id' => $sensorid])->one();
            return $this->render('sensor_rainfall', array('sensor' => $sensor));
        }else{
            return $this->render('sensor_rainfall', array('sensor' => null));
        }        
    }

    public function actionTemperature($sensorid=null){
        if (isset($sensorid)){
            $sensor = Sensor::find()->where(['id' => $sensorid])->one();
            return $this->render('sensor_temperature', array('sensor' => $sensor));
        }else{
            return $this->render('sensor_temperature', array('sensor' => null));
        }        
    }

    public function actionTracing($sensorid=null){
        if (isset($sensorid)){
            $sensor = Sensor::find()->where(['id' => $sensorid])->one();
            return $this->render('sensor_tracing', array('sensor' => $sensor));
        }else{
            return $this->render('sensor_tracing', array('sensor' => null));
        }
    }

    public function actionUploaddata($sensorid=null){
        $model = new UploaddataForm;

        try {
            if ($model->load($_POST) && $model->save()) {
                return $this->redirect(['/site/sensor', 'sensorid' => $model->id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }
        return $this->render('sensor_uploaddata', ['model' => $model]);
    }

}
