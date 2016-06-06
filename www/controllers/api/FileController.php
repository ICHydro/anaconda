<?php

namespace \api;

/**
* This is the class for REST controller "FileController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class FileController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\File';
}
