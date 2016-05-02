<?php

use yii\helpers\Html;
use yii\web\View;
$this->registerJsFile(Yii::getAlias('@web').'/js/popup.js', ['depends' => [yii\web\JqueryAsset::className()]]);


$this->title = 'Mountain-Evo - Maps';
use himiklab\colorbox\Colorbox;

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
            <div class="col-lg-3 sidenav-widget">
                <?php include_once ('inc/menu.php'); ?>
            </div>
            <div class="col-lg-9">


                <p><br /></p>
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
