<?php

use execut\widget\TreeView;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;

/* @var $tree_data app\controllers\SiteController */
/* @var $content app\controllers\SiteController */
/* @var $map_center app\controllers\SiteController */

Pjax::widget(['id' => 'content']);

$data = [];
foreach ($tree_data as $location => $sensors){
    $children = [];
    foreach ($sensors as $sensor){
        $entry = ['text' => $sensor->name, 'href' => Url::to(['']), 'sensor_id'=>$sensor->id];
        array_push($children, $entry);
    }
    $location_entry = ['text' => $location, 'nodes' => $children, 'href' => Url::to([''])];
    array_push($data, $location_entry);
}

$onSelect = new JsExpression(<<<JS
function (undefined, item) {
    if (item.sensor_id){
        fetchTSData(item.sensor_id);
    }
    else{
        $.pjax({
        container: 'body',
        timeout: null,
        url: '/site/observatory',
        type: 'POST',
        data: {'location':item.text}
    });
    }
}
JS
);

$groupsContent = TreeView::widget([
    'data' => $data,
    'size' => TreeView::SIZE_NORMAL,
    'template' => TreeView::TEMPLATE_SIMPLE,
    'clientOptions' => [
        'onNodeSelected' => $onSelect,
        'selectedBackColor' => 'rgb(40, 153, 57)',
        'borderColor' => '#fff',
    ],
]);

?>

<div class="container site-observatory">
    <!-- some css integrated here to obtain full page height -->
    <div class="row" style="display:table-row;height:100%;">

        <!-- TODO fix layout (responsive design) - canvas problem -->
        <div class="col-lg-3 col-xs-2 col-sm-2 sidenav-widget" style="display:table-cell;float: none;">
            <div class="row">
                <div class="locations-tree-view">
                    <h2>Locations</h2>
                    <!-- treeview widget from yii2-widget-bootstraptreeview -->
                    <?php echo $groupsContent; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-xs-10 col-sm-10" style="display:table-cell;float: none" id="content">
            <div class="row" style="height: 100%">
            <?php
            if (isset($content)){
                echo $this->render('observatory_content', ['content' => $content]);
                $map_source = '';
            }
            else{
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
            }
            ?>
            </div>
        </div>
    </div>
</div>






