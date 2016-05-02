<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\SensorSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="sensor-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'catchmentid') ?>

		<?= $form->field($model, 'latitude') ?>

		<?= $form->field($model, 'longitude') ?>

		<?php // echo $form->field($model, 'sensortype') ?>

		<?php // echo $form->field($model, 'units') ?>

		<?php // echo $form->field($model, 'height') ?>

		<?php // echo $form->field($model, 'width') ?>

		<?php // echo $form->field($model, 'angle') ?>

		<?php // echo $form->field($model, 'property') ?>

		<?php // echo $form->field($model, 'admin_email') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
