<?php

namespace \api;

/**
* This is the class for REST controller "CalibrationController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class CalibrationController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Calibration';
}
