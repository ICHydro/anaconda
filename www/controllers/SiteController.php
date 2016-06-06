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

    public function actionObservatory($locationid=null, $sensorid=null){
        if (isset($locationid)){
            $location = Catchment::find()->where(['id' => $locationid])->one();
            if (isset($sensorid)){
                $sensor = Sensor::find()->where(['id' => $sensorid])->one();
                return $this->render('sensor', array('location'=> $location, 'sensor' => $sensor));
            }else{
                $sensors = Sensor::find()->where(['catchmentid' => $location->id]) ->all();
                return $this->render('location', array('location'=> $location, 'sensors' => $sensors));
            }
        }
        $locations = Catchment::find()->all();
        return $this->render('observatory', array('locations' => $locations));
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
