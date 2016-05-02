<?php
use kartik\widgets\SideNav;
use yii\helpers\Html;
use himiklab\colorbox\Colorbox;
$this->registerJsFile(Yii::getAlias('@web').'/js/popup.js', ['depends' => [yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */

$this->title = 'Mountain-Evo - Indicators';
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
                <p><?=\Yii::t('infobar', 'Use Ecosystem Services indicators to gauge characteristics of a catchment.'); ?> <?=\Yii::t('infobar', 'Read more about the indicators or '); ?>
                   <?= Html::a(\Yii::t('infobar', 'select a sensor'), ['sensorpopup'], ['class' => 'popupss']); ?> <?=\Yii::t('infobar', 'to start.'); ?></p>
            </div>
        </div>
    </div>
            <div class="container  main-content">
                <div class="row">
                    <div class="col-sm-4">
                        <h3><?=\Yii::t('content', 'What are Ecosystem Services?'); ?></h3>
                        <p><?=\Yii::t('content', 'A brief description of what they are summing up the key points and why they are relevant and helpful to policy makers.'); ?></p>
                        <a class="btn btn-default" href="#" role="button"><?=\Yii::t('content', 'Read More'); ?></a>
                        <h3><?=\Yii::t('content', 'Interpreting the scores'); ?></h3>
                        <p><?=\Yii::t('content', 'Runoff ratio'); ?>: 0 (low) to 1 (high)</p>
                        <p><?=\Yii::t('content', 'Slope of flow duration curve make this scores meaningful.'); ?><br />
                        <?=\Yii::t('content', 'Base flow index'); ?>: 0 (low) to 1 (high)</p>
                        <a class="btn btn-default" href="#" role="button"><?=\Yii::t('content', 'ESS indicators explained'); ?></a>
                        <p></p>
                    </div>
                    <div class="col-sm-4 text-center" style='padding-top: 10%'>
                        <button type="button" class="btn btn-default btn-lg">
                              <span class="glyphicon glyphicon-play" aria-hidden="true"></span> <?=\Yii::t('content', 'Start'); ?>
                        </button>
                        <h3><?=\Yii::t('content', 'View ESS indicators'); ?></h3>
                        <p><?=\Yii::t('content', 'Choose a location, date range and/or conservation and the ESS indicator scores will appear here'); ?></p>
                    </div>
                    <div class="col-sm-4 text-center"  style='padding-top: 10%'>
                        <button type="button" class="btn btn-default btn-lg">
                              <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Compare
                        </button>
                        <h3><?=\Yii::t('content', 'Compare indicators'); ?></h3>
                        <p><?=\Yii::t('content', 'Select to compare to another location, date range and/or conservation type, and view ESS indicator scores here.'); ?></p>
                    </div>
                </div>
                <div class="row main-title">
                    <?=\Yii::t('content', 'Ecosystem Services in more depth'); ?>
                </div>    
                <div class="row main-block">
                    <h3>
                        Title of explanation
                    </h3>
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
                <div class="row main-title">
                    Ecosystem Services indicators explained
                </div>    
                <div class="row main-block">
                    <img src='<?php echo Yii::getAlias('@web'); ?><?=\Yii::t('images', '/images/photos/pluviometer.png'); ?>' class='img-responsive pull-right' />
                    <h3>
                        Runoff ratio
                    </h3>
                    <p>
                        Runoff ratio is the raiot of long-term average riverflow to the long-term average precipitation.
                        <br />It represents the long terms water balance separation between water being released from the watershed through the river and that returned to the atmosphere via evapotranpiration.
                    </p><p>
                        The runoff ratio is a property influenced by climate and soil conditions.
                    </p><p>
                        The score is..
                        <br />
                    </p>
                </div>   
                <div class="row main-block">
                    <img src='<?php echo Yii::getAlias('@web'); ?><?=\Yii::t('images', '/images/photos/ESS_Indicators.png'); ?>' class='img-responsive pull-right' />
                    <h3>
                        Slope of flow duration curve
                    </h3>
                    <p>
                        The flow duration curve (FDC) is the distribution of probabilities of daily riverflow being greater to or equal to a specified magnitude. 
                        <br />The slope of the curve on between the 33rd and 66th percentiles of the riverflow is relatively linear, and characterizes the riverflow variability.
                    </p>
                    <img src='<?php echo Yii::getAlias('@web'); ?><?=\Yii::t('images', '/images/photos/Observatory_Charts.png'); ?>' class='img-responsive' />
                </div>
                <div class="row main-block">
                    <img src='<?php echo Yii::getAlias('@web'); ?><?=\Yii::t('images', '/images/photos/pluviometer.png'); ?>' class='img-responsive pull-right' />
                    <h3>
                        Base flow index
                    </h3>
                    <p>
                        Base flow index (BFI) is the ratio of long term base flow to total streamflow.
                        A high value means that there is a higher base flow contribution, such that more water is using long and slow flow paths through the watershed.
                        Low values indicate a small amount of base flow between storm events to the streamflwo during or just after a storm event.
                        The BFI is a property of the regulation capavity of the soil that either enhances or impedes infiltration.
                    </p>
                </div>   

            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>

</div>
