<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\CalibrationSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="calibration-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'datetime') ?>

		<?= $form->field($model, 'height') ?>

		<?= $form->field($model, 'measure') ?>

		<?= $form->field($model, 'sensorid') ?>

		<?php // echo $form->field($model, 'yourname') ?>

		<?php // echo $form->field($model, 'youremail') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
