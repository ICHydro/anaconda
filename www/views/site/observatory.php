<!-- treeview widget -->

<?php

use execut\widget\TreeView;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use yii\helpers\Url;

Pjax::begin();
Pjax::end();

/* @var $tree_data app\controllers\SiteController */
/* @var $content app\controllers\SiteController */

$data = [];
foreach ($tree_data as $location => $sensors){
    $children = [];
    foreach ($sensors as $sensor){
        $entry = ['text' => $sensor->name, 'href' => Url::to(['', 'sensorid' => $sensor->id]),];
        array_push($children, $entry);
    }
    $location_entry = ['text' => $location, 'nodes' => $children];
    array_push($data, $location_entry);
}

$onSelect = new JsExpression(<<<JS
function (undefined, item) {
    if (item.href !== location.pathname) {
        $.pjax({
            container: '#content',
            url: item.href,
            timeout: null
        });
    }

    var otherTreeWidgetEl = $('.treeview.small').not($(this)),
        otherTreeWidget = otherTreeWidgetEl.data('treeview'),
        selectedEl = otherTreeWidgetEl.find('.node-selected');
    if (selectedEl.length) {
        otherTreeWidget.unselectNode(Number(selectedEl.attr('data-nodeid')));
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


<div class="site-observatory">

    <!-- some css integrated here to obtain full page height -->
    <div class="row" style="display:table-row;height:100%;">

        <!-- TODO fix layout (responsive design) -->
        <div class="col-lg-3 sidenav-widget" style="display:table-cell;float: none;">
            <h3>Locations</h3>
            <?php echo $groupsContent; ?>
        </div>

        <div class="col-lg-9" style="display:table-cell;float: none;" id="content">
            <?php
                if (isset($content)){
                    echo $content;
                }
                else{
                    echo 'No content found.';
                }
            ?>
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

<?php
    if (!isset($content)){
        $map_source = "https://maps.googleapis.com/maps/api/js?key=".Yii::$app->params['google_api_key']."&callback=initMap";
    }
    else{
        $map_source = '';
    }
?>

<script async defer src="<?=$map_source?>" type="text/javascript"></script>






