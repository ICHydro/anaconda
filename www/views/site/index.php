<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Mountain-EVO - index';
?>
<div class="site-index">

    <div class="container jumbotron banner" style="background-image: url('<?php echo Yii::getAlias('@web'); ?>/images/photos/Home_Banner.png');">
        <div class='row'>
            <div class="col-sm-12 padding-right-20px"><h3><b><?=\Yii::t('content', 'Environmental virtual observatories'); ?></b></h3>
                <p><?=\Yii::t('content', 'Mountain-EVO is a shared virtual observatory of ecosystem services in remote mountain regions.'); ?> 
                    <?=\Yii::t('content', ''); ?>
                </p>
                <p><?=\Yii::t('content', 'It was developed by the eponymous research project led by Imperial College London, but is now developed further by a broader community of scientists and stakeholders'); ?></p>
            </div>
<!--            <div class="col-sm-4 bottom-align-text">
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
                </div> -->
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row infoblocks">
            <div class="col-sm-4">
                <div>
                    <?=Html::a("<img src='".Yii::getAlias('@web')."/images/photos/Observatory_Charts.png' class='img-responsive'>", 'site/observatory'); ?>
                    <h2><span class="glyphicon glyphicon-tent"></span><?=\Yii::t('content', ' Observations'); ?></h2>
                    <p><?=\Yii::t('content', 'Explore observation data and graphs'); ?></p>
                    <!-- <p><?=Html::a(\Yii::t('content', 'read more'), 'site/observatory'); ?></p> -->
                </div>
            </div>
            <div class="col-sm-4">
                <div>
                    <?=Html::a("<img src='".Yii::getAlias('@web')."/images/photos/ESS_Indicators.png' class='img-responsive'>", 'site/indicators'); ?>
                    <h2><span class="glyphicon glyphicon-dashboard"></span><?=\Yii::t('content', ' Dashboard'); ?></h2>
                    <p><?=\Yii::t('content', 'Tablet-friendly visualizations'); ?></p>
                    <!-- <p><?=Html::a(\Yii::t('content', 'read more'), 'site/indicators'); ?></p> -->
                </div>
            </div>
            <div class="col-sm-4">
                <div>
                    <?=Html::a("<img src='".Yii::getAlias('@web')."/images/photos/ESS_Indicators.png' class='img-responsive'>", 'site/sensors'); ?>
                    <h2><span class="glyphicon glyphicon-blackboard"></span><?=\Yii::t('content', ' Learning center'); ?></h2>
                    <p><?=\Yii::t('content', 'Learn about mountain processes and sensors'); ?></p>
                    <!-- <p><?=Html::a(\Yii::t('content', 'read more'), 'site/sensors'); ?></p> -->
                </div>
            </div>
        </div>
    </div>

</div>
