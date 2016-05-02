<?php

namespace \api;

/**
* This is the class for REST controller "SensorController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SensorController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Sensor';
}
