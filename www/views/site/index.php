<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Mountain-Evo - index';
?>
<div class="site-index">

    <div class="container jumbotron banner" style="background-image: url('<?php echo Yii::getAlias('@web'); ?>/images/photos/Home_Banner.png');">
        <div class='row'>
            <div class="col-sm-6 padding-right-20px"><h3><b><?=\Yii::t('content', 'What is Mountain-Evo?'); ?></b></h3>
                <p><?=\Yii::t('content', 'Mountain-Evo is a shared virtual observatory of remote mountain socio-ecological systems for poverty alleviation.'); ?> 
                    <?=\Yii::t('content', 'Put the updated blurb and explanation about the site in here so that people get the website.'); ?>
                </p>
                <p><?=\Yii::t('content', 'Data is being collected in four case study locations: Peru, Kryzgstan, Nepal and Ethiopia.'); ?></p>
            </div>
            <div class="col-sm-6 bottom-align-text">
                <p><?=\Yii::t('content', 'Explore two sections on Mountain-Evo:'); ?></p>
                <div class='row'>
                    <div class="col-sm-6">
                        <div class='dark-back'>
                            <h3><span class="glyphicon glyphicon-tent"></span> <?=\Yii::t('content', 'Observatory'); ?></h3>
                            <?=\Yii::t('content', 'See temperature rainfall, and riverflow data collected, and learn about the sensors'); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class='dark-back'>
                            <h3><span class="glyphicon glyphicon-record"></span> <?=\Yii::t('content', 'ESS indicators'); ?></h3>
                            <?=\Yii::t('content', 'Find out about Ecosystem Services, and check compare ESS indicator scores'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row infoblocks">
            <div class="col-sm-4">
                <div>
                    <?=Html::a("<img src='".Yii::getAlias('@web')."/images/photos/Observatory_Charts.png' class='img-responsive'>", 'site/observatory'); ?>
                    <h2><?=\Yii::t('content', 'Observatory charts'); ?></h2>
                    <p><?=\Yii::t('content', 'View rainfall data for a location'); ?></p>
                    <p><?=Html::a(\Yii::t('content', 'read more'), 'site/observatory'); ?></p>
                </div>
            </div>
            <div class="col-sm-4">
                <div>
                    <?=Html::a("<img src='".Yii::getAlias('@web')."/images/photos/ESS_Indicators.png' class='img-responsive'>", 'site/indicators'); ?>
                    <h2><?=\Yii::t('content', 'ESS Indicators explained'); ?></h2>
                    <p><?=\Yii::t('content', 'Find out what base flow index shows'); ?></p>
                    <p><?=Html::a(\Yii::t('content', 'read more'), 'site/indicators'); ?></p>
                </div>
            </div>
            <div class="col-sm-4">
                <div>
                    <?=Html::a("<img src='".Yii::getAlias('@web')."/images/photos/Sensors.png' class='img-responsive'>", 'site/sensors'); ?>
                    <h2><?=\Yii::t('content', 'About the sensors'); ?></h2>
                    <p><?=\Yii::t('content', 'Learn how they measure data'); ?></p>
                    <p><?=Html::a(\Yii::t('content', 'read more'), 'site/sensors'); ?></p>
                </div>
            </div>
        </div>
    </div>

</div>
