<?php

namespace \api;

/**
* This is the class for REST controller "CatchmentController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class CatchmentController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Catchment';
}
