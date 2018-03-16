<?php

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use yii\helpers\Html;

/* @var $tree_data app\controllers\SiteController */
/* @var $map_center app\controllers\SiteController */
?>

<div class="row" style="height: 100%">

<?php
$center = new LatLng(['lat' => $map_center['lat'], 'lng' => $map_center['lon']]);
$map = new Map([
    'center' => $center,
    'zoom' => 4,
    'width' => '100%',
    'height' => '100%',
]);

foreach ($tree_data as $sensors){
    foreach ($sensors as $sensor) {
        $position = new LatLng(['lat' => $sensor->latitude, 'lng' => $sensor->longitude]);
        $map_marker = new Marker([
            'position' => $position,
        ]);

        $map_marker->attachInfoWindow(
            new InfoWindow([
                'content' => Html::Button($sensor->name,
                    ['class' => 'show_sensor_data', 'value' => $sensor->id, 'onclick' =>'fetchTSData(this.value)'])
            ])
        );

        $map->addOverlay($map_marker);
    }
}

echo $map->display();
?>
</div>
