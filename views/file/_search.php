<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\FileSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="file-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'filelink') ?>

		<?= $form->field($model, 'filename') ?>

		<?= $form->field($model, 'extension') ?>

		<?= $form->field($model, 'startdate') ?>

		<?php // echo $form->field($model, 'enddate') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'sensorid') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
