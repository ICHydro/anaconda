<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Catchment;
use app\models\Sensor;
use app\models\UploaddataForm;
use app\models\Observation;



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

    public function actionObservatory($sensorid=null){
        $content = null;
        $data_points = [];
        if (isset($sensorid)){
            // TODO get search parameters from user (view)
            $dataPoints = [];
            $con1 = '2016-04-02 15:40:00';
            $con2 = '2016-05-02 17:00:00';
            $numIntervals = 400;
            $includeMinMax = true;

            $results = Observation::find()->
            where(['sensor_id' => $sensorid])->
            andWhere(['between','timestamp',$con1,$con2])->
            orderBy('timestamp ASC')->all();

            //TODO use samplings from fetch_simple
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
            $sensor = Sensor::find()->where(['id' => $sensorid])->one();
            $catchment = Catchment::find()->where(['id' => $sensor->catchmentid])->one();
            $content = array(
                'sensor' => $sensor,
                'catchment' => $catchment,
                'data_points' => json_encode($data_points)
            );

        }

        $locations = Catchment::find()->all();
        $tree_data = array();
        foreach ($locations as $location) {
            $location_name = $location->getAttribute('name');
            $sensors = Sensor::find()->where(['catchmentid' => $location->id])->all();
            $tree_data[$location_name] = $sensors;
        }

        $this->layout='main_nofooter.php';
        return $this->render('observatory',  array(
            'tree_data' => $tree_data,
            'content' => $content,
        ));
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
