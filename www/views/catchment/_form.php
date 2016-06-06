<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\Catchment $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="catchment-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Catchment',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            
			<?= $form->field($model, 'id')->textInput() ?>
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'name_es')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'name_ne')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
			<?= $form->field($model, 'description_es')->textarea(['rows' => 6]) ?>
			<?= $form->field($model, 'description_ne')->textarea(['rows' => 6]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                   'encodeLabels' => false,
                     'items' => [ [
    'label'   => $model->getAliasModel(),
    'content' => $this->blocks['main'],
    'active'  => true,
], ]
                 ]
    );
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save')),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

