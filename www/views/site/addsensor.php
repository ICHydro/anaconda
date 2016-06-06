<?php
use kartik\widgets\SideNav;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use app\models\Catchment;


/* @var $this yii\web\View */

$this->title = 'Mountain-Evo - Add a Sensor';
?>
<div class="site-addsensor">

    <div class="container warning-message">
        <div class='row'>
            <div class="col-lg-12  text-center">
            </div>
        </div>
    </div>
            <div class="container  main-content">
                <div class="row">
                    <div class="col-lg-3 sidenav-widget">
                        <?php //include_once ('inc/menu.php'); ?>
                    </div>
                    <div class="col-lg-9">
                        <?= Html::beginForm(['/site/addsensor'], 'post'); ?>
                        <div class='row main-header'>
                            <div class="col-lg-12">
                                <h2><?=\Yii::t('app', 'Add Sensor'); ?></h2>
                            </div>  
                            <div class="col-lg-4">
                                <?=\Yii::t('app', 'NAME SENSOR'); ?><br /><?=\Yii::t('app', 'e.g. River [name] Sensor'); ?>
                            </div>  
                            <div class="col-lg-8">
                                <?php echo Html::activeInput('text', $model, 'name'); ?>
                            </div>  
                            <div class="col-lg-12">
                                <hr>
                            </div>  

                            <div class="col-lg-4">
                                <?=\Yii::t('app', 'LOCATION'); ?>
                            </div>  
                            <div class="col-lg-8">
                                <?php /*= $form->field($model, 'catchmentid', ['template' => '{input}{error}{hint}'])->dropDownList(\yii\helpers\ArrayHelper::map(app\models\Catchment::find()->all(), 'id', 'name'),
                                ['prompt' => Yii::t('app', 'Select')]
                                ); */ ?>
                                <?= Html::activeDropDownList($model, 'catchmentid', ArrayHelper::map(Catchment::find()->all(), 'id', 'name')) ?>

                                
                            </div>   
                            <div class="col-lg-12">
                                <hr>
                            </div>


                            <div class="col-lg-4">
                                <?=\Yii::t('app', 'TYPE OF SENSOR'); ?>
                            </div>  
                            <div class="col-lg-8">
                                <?php echo Html::activeRadioList($model, 'sensortype', ['Weighing Gauge' => 'Weighing Gauge',
                                                                                        'Accoustic Rain' => 'Accoustic Rain',
                                                                                        'Burried Pit' => 'Burried Pit',
                                                                                        'Rain Gauge' => 'Rain Gauge',
                                                                                        'Tip Bucket' => 'Tip Bucket',
                                                                                        'Graduated Cylinder' => 'Graduated Cylinder',
                                                                                        ], [
                                    'class' => 'btn-group' , 
                                    'data' => ['toggle' => 'buttons'],
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        return '<label class="btn btn-default">' . Html::radio($name, $checked, ['value'  => $value]) . $label . '</label>';
                                    }
                                ]); ?>
                            </div>  
                            <div class="col-lg-12">
                                <hr>
                            </div>

                            <div class="col-lg-4">
                                <?=\Yii::t('app', 'SENSOR LOCATION'); ?>
                            </div>  
                            <div class="col-lg-8">
                                <?php echo Html::activeInput('text', $model, 'latitude'); ?> °N<br />
                                <?php echo Html::activeInput('text', $model, 'longitude'); ?> °W
                                <br />
                                <button type="button" class="btn"><?=\Yii::t('app', 'Choose on map'); ?></button>
                            </div>  
                            <div class="col-lg-12">
                                <hr>
                            </div>  

                            <div class="col-lg-4">
                                <?=\Yii::t('app', 'UNITS'); ?>
                            </div>  
                            <div class="col-lg-8">
                                <?php echo Html::activeRadioList($model, 'units', ['mm' => 'mm', 'inch' => 'inch'], [
                                    'class' => 'btn-group' , 
                                    'data' => ['toggle' => 'buttons'],
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        return '<label class="btn btn-default">' . Html::radio($name, $checked, ['value'  => $value]) . $label . '</label>';
                                    }
                                ]); ?>
                            </div>  
                            <div class="col-lg-12">
                                <hr>
                            </div>

                            <div class="col-lg-4">
                                <?=\Yii::t('app', 'OBSERVED PROPERTY'); ?>
                            </div>  
                            <div class="col-lg-8">
                                <?= Html::activeDropDownList($model, 'property', [  'Observation 1' => 'Observation 1',
                                                                                    'Observation 2' => 'Observation 2',
                                                                                    'Observation 3' => 'Observation 3',
                                                                                    'Observation 4' => 'Observation 4',
                                                                                ]) ?>
                            </div>  
                            <div class="col-lg-12">
                                <hr>
                            </div>


                            <div class="col-lg-4">
                                <?=\Yii::t('app', 'SENSOR ADMIN MAIL'); ?>
                                <br /><?=\Yii::t('app', 'Who will be uploading data?'); ?>
                            </div>  
                            <div class="col-lg-8">
                                <?php echo Html::activeInput('text', $model, 'admin_email'); ?>
                            </div>  
                            <div class="col-lg-12 text-center">
                                <?php echo Html::errorSummary($model); ?>

                                <?= Html::submitButton(
                                    '<span class="glyphicon glyphicon-check"></span> ' .
                                    ($model->isNewRecord ? \Yii::t('app', 'Create sensor') : \Yii::t('app', 'Save sensor')),
                                    [
                                    'id' => 'save-' . $model->formName(),
                                    'class' => 'btn btn-danger'
                                    ]
                                    );
                                ?>
                            </div>  
                            <div class="col-lg-12">
                                <br /><br /><br />
                            </div>  
                        </div>
                        <?php Html::endForm(); ?>
                        <br /><br /><br />
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>

</div>
