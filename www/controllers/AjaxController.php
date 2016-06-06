<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Catchment;
use app\models\Sensor;
use yii\helpers\Url;


class AjaxController extends Controller
{

    public function actionSensors($locationid){
        $location = Catchment::find()->where(['id' => $locationid]) ->One();
        return $this->renderPartial('sensors', array('location' => $location));
    }


}
