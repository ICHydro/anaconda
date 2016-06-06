<?php

use yii\helpers\Html;
use yii\web\View;
$this->registerJsFile(Yii::getAlias('@web').'/js/popup.js', ['depends' => [yii\web\JqueryAsset::className()]]);
$text = '$(".nav-tabs a").click(function(event) { event.preventDefault(); $(this).tab("show"); bar2.resize(); bar3.resize(); bar1.resize(); });';
$this->registerJs($text,  \yii\web\View::POS_READY);


    

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
            <div class="col-lg-3 sidenav-widget">
                <?php include_once ('inc/menu.php'); ?>
            </div>
            <div class="col-lg-9">

                    <div class="tabbable">
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <?php
                                    $data = array(
                                        array('2008-05-06', 20),
                                        array('2008-05-07', 36),
                                        array('2008-05-08', 33),
                                        array('2008-05-12', 23),
                                    );
                                echo DygraphsWidget::widget([
                                    'data' => $data,
                                    'xIsDate' => true,
                                    'jsVarName' => 'bar1',
                                    'options' => ['labels' => array(null, 'Rainfall(mm)')],
                                    //'width' => '100%',
                                ]);
                                ?>
                            </div>
                            <div id="tab2" class="tab-pane">
                                <?php
                                    $data = array(
                                        array('2008-05-06', 20),
                                        array('2008-05-07', 36),
                                        array('2008-05-08', 30),
                                        array('2008-05-12', 23),
                                    );
                                echo DygraphsWidget::widget([
                                    'data' => $data,
                                    'xIsDate' => true,
                                    'jsVarName' => 'bar2',
                                    'options' => ['width' => '800', 'labels' => array(null, 'Rainfall(mm)')],
                                ]);
                                ?>
                            </div>
                            <div id="tab3" class="tab-pane">
                                <?php
                                    $data = array(
                                        array('2008-05-06', 20),
                                        array('2008-05-07', 30),
                                        array('2008-05-08', 33),
                                        array('2008-05-12', 23),
                                    );
                                echo DygraphsWidget::widget([
                                    'data' => $data,
                                    'xIsDate' => true,
                                    'jsVarName' => 'bar3',
                                    'options' => ['width' => '800', 'labels' => array(null, 'Rainfall(mm)')],
                                    //'width' => '100%',
                                ]);
                                ?>
                            </div>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">GRAPH</a></li>
                            <li><a href="#tab2" data-toggle="tab">BAR CHART</a></li>
                            <li><a href="#tab3" data-toggle="tab">TABLE</a></li>
                        </ul>
                    </div>
                
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
