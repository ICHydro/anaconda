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
use app\components\utility\GeometryUtils;


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
            $now=strtotime("now");
            $con1 = date("Y-m-d H:i:s", strtotime("-".$time_span, $now));
            $con2 = date("Y-m-d H:i:s", $now);  // e.g.'2016-04-02 15:40:00'

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("
              SELECT json_agg(json_build_object('time', timestamp, 'value', value))  AS agg 
              FROM observations WHERE 
                sensor_id = :sensor_id AND 
                timestamp >= :start_date AND 
                timestamp < :end",
                [
                    ':sensor_id' => $sensor_id,
                    ':start_date' => $con1,
                    ':end' => $con2
                ]
            );

            $result = $command->queryAll();
            $data_points = (isset($result[0]['agg']) ? $result[0]['agg'] : '[]');
            $sensor = Sensor::find()->where(['id' => $sensor_id])->one();
            $catchment = Catchment::find()->where(['id' => $sensor->catchmentid])->one();
            $content = array(
                'sensor' => $sensor,
                'catchment' => $catchment,
                'data_points' => $data_points,
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
                        array_push($coordinates, ['lat'=>$sensor->latitude,'lon'=>$sensor->longitude]);
                    }
                    $center = GeometryUtils::getCoordsCenter($coordinates);
                    $markers_centers[$location_name] = ['lat'=>$center['lat'], 'lon'=>$center['lon']];
                }
            }

            // center map to selected location
            if (isset($selected_location)){
                $map_center = ['lat' => $markers_centers[$selected_location]['lat'], 'lon'=>$markers_centers[$selected_location]['lon']];
                return $this->renderAjax('observatory_map',  array(
                    'tree_data' => $tree_data,
                    'map_center' => $map_center,
                ));
            }
            else {
                $map_center = GeometryUtils::getCoordsCenter($markers_centers);
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
