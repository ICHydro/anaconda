
<!-- next block is for the sensor popup. Can be removed once pop up funcionality is integrated in main page -->

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

<!-- end popup block -->

<div class="site-observatory">

    <!-- some css integrated here to obtain full page height -->
    <div class="row" style="display:table-row;height:100%;">

        <div class="col-lg-3 sidenav-widget" style="display:table-cell;float: none;">
                <?php include_once ('inc/menu.php'); ?>
                <?= Html::a(\Yii::t('infobar', 'select a sensor'), ['sensorpopup'], ['class' => 'popupss']); ?> <?=\Yii::t('infobar', 'to start.'); ?></p>

        </div>

        <div class="col-lg-9" style="display:table-cell;float: none;" id="map">
        </div>

    </div>


</div>

<script>

function initMap() {
        var center = {lat: -3, lng: -71.66};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5,
          center: center
        });
}
</script> 

<script async defer src="<?="https://maps.googleapis.com/maps/api/js?key=".Yii::$app->params['google_api_key']."&callback=initMap"?>" type="text/javascript"></script>



<!--                <?php
                    foreach ($locations as $location) {
                        echo "<h3>".ucfirst($location->getName())."</h3>";
                        echo $location->getDescription();
                        echo "<br />";
                        echo Html::a("View details for ". $location->getName(), ['sensorpopup', 'locationid' => $location->id], ['class' => 'btn btn-primary popupss']);
                    }
                ?>
                -->


