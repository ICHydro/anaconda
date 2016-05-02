<?php

use yii\helpers\Html;
use yii\web\View;
$this->registerJsFile(Yii::getAlias('@web').'/js/popup.js', ['depends' => [yii\web\JqueryAsset::className()]]);


    

$this->title = 'Mountain-Evo - '.ucfirst(Yii::$app->controller->action->id);
use himiklab\colorbox\Colorbox;
use sibilino\y2dygraphs\DygraphsWidget;

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
<div class="site-observatory">

    <div class="container warning-message">
        <div class='row'>
            <div class="col-lg-12  text-center">
                <p>
                    <?=\Yii::t('infobar', 'This is the information for'); ?> <span class='highlight'><?=htmlentities($sensor->name) ?></span>, <?=\Yii::t('infobar', 'located in'); ?> <span class='highlight'><?=htmlentities($sensor->catchment->name) ?></span>. 
                    <?= Html::a(\Yii::t('infobar', 'Change location').' <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>', ['sensorpopup', 'locationid' => $sensor->catchment->id], ['class' => 'popupss pull-right']); ?>
               </p>
            </div>
        </div>
    </div>

    <div class="container  main-content">
        <div class="row">
            <div class="col-sm-3  col-xs-12 sidenav-widget">
                <?php include_once ('inc/menu.php'); ?>
            </div>
            <div class="col-sm-9 .col-sm-offset-1 col-xs-12 box" style='padding-left: 10%'>
                <img class='img-responsive pull-right' src='<?php echo Yii::getAlias('@web')."/images/photos/".$sensor->sensortype.".png"; ?>'>
                    <h3>Sensor information</h3>
                    <b>Name: </b><?=$sensor->name ?><br />
                    <b>Location: </b><?=$sensor->catchment->name ?><br />
                    <b>Latitude: </b><?=$sensor->latitude ?> °<br />
                    <b>Longitude: </b><?=$sensor->longitude ?> °<br />
                    <b>Sensor Type: </b><?=$sensor->sensortype ?><br /><br /><br />
            </div>
        </div>
        <div class="row main-title">
            How is this data collected?
        </div>    
        <div class="row main-block">
            <img src='<?php echo Yii::getAlias('@web'); ?>/images/photos/pluviometer.png' class='img-responsive' />
            <h2>
                Pluvio Meter
            </h2>
            <p>
                Explain what sensors are used, how data is collected, etc <br />
                Explain<br />
                Eplain<br />
                <br /><br />
                <a href="#">Read more link</a>
                <br />
                <br />
                Find out about all the types of weather sensor used in these areas.
            </p>
        </div>    
    </div>

</div>
