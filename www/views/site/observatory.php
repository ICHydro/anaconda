<!-- treeview widget from yii2-widget-bootstraptreeview -->

<?php

use execut\widget\TreeView;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $tree_data app\controllers\SiteController */
/* @var $content app\controllers\SiteController */
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
    fetchTSData(item.sensor_id);
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
            <h2>Locations</h2>
            <?php echo $groupsContent; ?>
        </div>

        <div class="col-lg-9 col-xs-10 col-sm-10" style="display:table-cell;float: none" id="content">
            <?php
            if (isset($content)){
                echo $this->render('observatory_content', ['content' => $content]);
                $map_source = '';
            }
            else{
                $map_source = "https://maps.googleapis.com/maps/api/js?key=".Yii::$app->params['google_api_key']."&callback=initMap";
            }
            ?>
        </div>
    </div>
</div>

<script>
    // TODO create vector layer with sensors based on their location
    // center on map extent of sensor vector layer
    function initMap() {
        var center = {lat: -3, lng: -71.66};
        var map = new google.maps.Map(document.getElementById('content'), {
            zoom: 5,
            center: center
        });
    }
</script>

<script async defer src="<?=$map_source?>" type="text/javascript"></script>






