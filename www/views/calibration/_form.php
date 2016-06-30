<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\Calibration $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="calibration-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Calibration',
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
			<?= $form->field($model, 'datetime')->textInput() ?>
			<?= $form->field($model, 'height')->textInput() ?>
			<?=                         $form->field($model, 'measure')->dropDownList(
                            app\models\Calibration::optsmeasure()
                        ); ?>
			<?= // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::activeField
$form->field($model, 'sensorid')->dropDownList(
    \yii\helpers\ArrayHelper::map(app\models\Sensor::find()->all(), 'id', 'name'),
    ['prompt' => Yii::t('app', 'Select')]
); ?>
			<?= $form->field($model, 'yourname')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'youremail')->textInput(['maxlength' => true]) ?>
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
