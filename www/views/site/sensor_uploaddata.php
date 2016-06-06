<?php
$this->registerJsFile(Yii::getAlias('@web').'/js/popup.js', ['depends' => [yii\web\JqueryAsset::className()]]);

use kartik\widgets\SideNav;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use app\models\Catchment;
use app\models\Sensor;
use yii\jui\DatePicker;


/* @var $this yii\web\View */

$this->title = 'Mountain-Evo - Add a Sensor';
?>
<div class="site-addsensor">

    <div class="container warning-message">
        <div class='row'>
            <div class="col-sm-12  text-center">
            </div>
        </div>
    </div>
            <div class="container  main-content">
                <div class="row">
                    <div class="col-sm-3 sidenav-widget">
                        <?php include_once ('inc/menu.php'); ?>
                    </div>
                    <div class="col-sm-9">
                        <?= Html::beginForm(['/site/uploaddata'], 'post', ['enctype'=>'multipart/form-data']); ?>
                        <div class='row main-header'>
                            <div class="col-sm-12">
                                <h2><?=\Yii::t('app', 'Upload Data'); ?></h2>
                            </div>  

                            <div class="col-sm-4">
                                <?=\Yii::t('app', 'LOCATION'); ?>
                            </div>  
                            <div class="col-sm-8">
                                <?= Html::activeDropDownList($model, 'catchmentid', ArrayHelper::map(Catchment::find()->all(), 'id', 'name')) ?>
                            </div>   
                            <div class="col-sm-12">
                                <hr>
                            </div>

                            <div class="col-sm-4">
                                <?=\Yii::t('app', 'SENSORS'); ?>
                            </div>  
                            <div class="col-sm-4">
                                <?= Html::activeDropDownList($model, 'sensorid', ArrayHelper::map(Sensor::find()->all(), 'id', 'name')) ?>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn"><?=\Yii::t('app', 'Choose on map'); ?></button>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>


                            <div class="col-sm-4">
                                <?=\Yii::t('app', 'DATE RECORDED'); ?>
                            </div>  
                            <div class="col-sm-8">
                                <?php 
                                if (!isset($model->date)){
                                    $model->date=date('Y-m-d');
                                }
                                echo DatePicker::widget([
                                    'model' => $model,
                                    'attribute' => 'date',
                                    //'language' => 'ru',
                                    'dateFormat' => 'yyyy-MM-dd',
                                ]);
                                ?><br />
                            </div>  
                            <div class="col-sm-12">
                                <hr>
                            </div>

                            <div class="col-sm-4">
                                <?=\Yii::t('app', 'READING'); ?>
                            </div>  
                            <div class="col-sm-8">
                                <?php echo Html::activeInput('text', $model, 'reading'); ?> mm<br />
                                - or - <br />
                                <?php echo Html::activeFileInput($model, 'file', 
                                    ['pluginOptions'=>['allowedFileExtensions'=>['txt','csv','xls','xlsx']]
                                    ]); ?><br />
                                <?=\Yii::t('app', 'Upload a .csv file'); ?>
                                
                            </div>  
                            <div class="col-sm-12">
                                <hr>
                            </div>  


                            <div class="col-sm-4">
                                <?=\Yii::t('app', 'YOUR NAME'); ?>
                                <br /><?=\Yii::t('app', 'This will be send to the admin to verify the data readings'); ?>
                            </div>  
                            <div class="col-sm-8">
                                <?php echo Html::activeInput('text', $model, 'yourname'); ?>
                            </div>  
                            <div class="col-sm-12">
                                <hr>
                            </div>  
                            <div class="col-sm-4">
                                <?=\Yii::t('app', 'YOUR EMAIL'); ?>
                                <br /><?=\Yii::t('app', 'If the sensor admin has a question, he will contact you'); ?>
                            </div>  
                            <div class="col-sm-8">
                                <?php echo Html::activeInput('text', $model, 'youremail'); ?>
                            </div>  

                            <div class="col-sm-12 text-center">
                                <?php echo Html::errorSummary($model); ?>

                                <?= Html::submitButton(
                                    '<span class="glyphicon glyphicon-check"></span> Upload Data',
                                    [
                                    'id' => 'save-' . $model->formName(),
                                    'class' => 'btn btn-danger'
                                    ]
                                    );
                                ?>
                            </div>  
                            <div class="col-sm-12">
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
