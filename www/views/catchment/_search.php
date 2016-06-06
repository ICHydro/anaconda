<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\CatchmentSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="catchment-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'name_es') ?>

		<?= $form->field($model, 'name_ne') ?>

		<?= $form->field($model, 'description') ?>

		<?php // echo $form->field($model, 'description_es') ?>

		<?php // echo $form->field($model, 'description_ne') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
