<?php

use yii\helpers\Html;
use yii\web\View;
$this->registerJsFile(Yii::getAlias('@web').'/js/popup.js', ['depends' => [yii\web\JqueryAsset::className()]]);


$this->title = 'Mountain-Evo - Observatory';
use himiklab\colorbox\Colorbox;

?>

<?= Colorbox::widget([
    'targets' => [
        '.colorbox' => [
            'initialWidth' => "800",
            'initialHeight' => "600",
        ],
    ],
    'coreStyle' => 1
]) ?>
<div class="site-observatory">

    <div class="container warning-message">
        <div class='row'>
            <div class="col-lg-12  text-center">
                <p><?=\Yii::t('infobar', 'Use these graphs and maps to explore data collected by local environmental sensors.'); ?> 
                   <?= Html::a(\Yii::t('infobar', 'select a sensor'), ['sensorpopup'], ['class' => 'popupss']); ?> <?=\Yii::t('infobar', 'to start.'); ?></p>
            </div>
        </div>
    </div>

    <div class="container  main-content">
        <div class="row">
            <div class="col-lg-3 sidenav-widget">
                <?php include_once ('inc/menu.php'); ?>
            </div>
            <div class="col-lg-9">
                <?php
                    foreach ($locations as $location) {
                        echo "<h3>".ucfirst($location->getName())."</h3>";
                        echo $location->getDescription();
                        echo "<br />";
                        echo Html::a("View details for ". $location->getName(), ['sensorpopup', 'locationid' => $location->id], ['class' => 'btn btn-primary popupss']);
                    }
                ?>
                <p><br /></p>
            </div>
        </div>
        <div class="row main-title">
            <?=\Yii::t('content', 'How is this data collected?'); ?>
        </div>    
        <div class="row main-block">
            <img src='<?php echo Yii::getAlias('@web'); ?><?=\Yii::t('images', '/images/photos/pluviometer.png'); ?>' class='img-responsive' />
            <h2>
                <?=\Yii::t('content', 'Pluvio Meter'); ?>
            </h2>
            <p>
                <?=\Yii::t('content', 'Explain what sensors are used, how data is collected, etc'); ?> <br />
                <?=\Yii::t('content', 'Explain'); ?><br />
                <?=\Yii::t('content', 'Eplain'); ?><br />
                <br /><br />
                <a href="#"><?=\Yii::t('content', 'Read more link'); ?></a>
                <br />
                <br />
                <?=\Yii::t('content', 'Find out about all the types of weather sensor used in these areas.'); ?>
            </p>
        </div>    
    </div>

</div>
