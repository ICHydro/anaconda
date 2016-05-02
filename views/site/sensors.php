<?php
use kartik\widgets\SideNav;
use yii\helpers\Html;
use himiklab\colorbox\Colorbox;
$this->registerJsFile(Yii::getAlias('@web').'/js/popup.js', ['depends' => [yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */

$this->title = 'Mountain-Evo - Sensor types';
?>
<?= Colorbox::widget([
    'targets' => [
        '.colorbox' => [
            'width' => 800,
            'height' => 600,
        ],
    ],
    'coreStyle' => 1
]) ?>
<div class="site-indicators">

    <div class="container warning-message">
        <div class='row'>
            <div class="col-sm-12  text-center">
                <p><?=\Yii::t('infobar', 'Read more about the sensor types, or '); ?>
                   <?= Html::a(\Yii::t('infobar', 'select a sensor'), ['sensorpopup'], ['class' => 'popupss']); ?> <?=\Yii::t('infobar', 'to start.'); ?></p>
            </div>
        </div>
    </div>
            <div class="container" style='padding: 0px;'>
                <img class='img-responsive' src='<?php echo Yii::getAlias('@web'); ?>/images/photos/Sensors_Banner.png'); ?>
            </div>
            <div class="container  main-content">
                <div class="row main-title">
                    Sensor Information
                </div>    
                <div class="row main-block">
                    <img src='<?php echo Yii::getAlias('@web'); ?>/images/photos/pluviometer.png' class='img-responsive' />
                    <h3>
                        What are the sensors?
                    </h3>
                    <p>
                        Short overview of what sensors are, information about the location of the sensors
                        Description of the types being used.
                    </p>
                    <p>
                        There are 6 different types of sensor being used in the location, see more about how they each work.
                    </p>
                </div>   
            </div>
            <div class="container videos">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-xs-12">
                        <div class='box'>
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/ZaTMvOyUzyo" frameborder="0" allowfullscreen></iframe>
                            <h3>Weighing gauge</h3>
                            <p>Description of the sensor...</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xs-12">
                        <div class='box'>
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/ZaTMvOyUzyo" frameborder="0" allowfullscreen></iframe>
                            <h3>Tip Bucket</h3>
                            <p>Description of the sensor...</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xs-12">
                        <div class='box'>
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/ZaTMvOyUzyo" frameborder="0" allowfullscreen></iframe>
                            <h3>Acoustic rain</h3>
                            <p>Description of the sensor...</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xs-12">
                        <div class='box'>
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/ZaTMvOyUzyo" frameborder="0" allowfullscreen></iframe>
                            <h3>Graduated Cylinder</h3>
                            <p>Description of the sensor...</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xs-12">
                        <div class='box'>
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/ZaTMvOyUzyo" frameborder="0" allowfullscreen></iframe>
                            <h3>Rain gauge</h3>
                            <p>Description of the sensor...</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xs-12">
                        <div class='box'>
                            <iframe width="100%" height="100%" src="https://www.youtube.com/embed/ZaTMvOyUzyo" frameborder="0" allowfullscreen></iframe>
                            <h3>Buried Pit</h3>
                            <p>Description of the sensor...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>

</div>
