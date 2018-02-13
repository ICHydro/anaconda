<!-- treeview widget from yii2-widget-bootstraptreeview -->

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
    $location_entry = ['text' => $location, 'nodes' => $children, 'href' => Url::to([''])];
    array_push($data, $location_entry);
}

$onSelect = new JsExpression(<<<JS
function (undefined, item) {
        $.pjax({
            container: '#content',
            url: item.href,
            timeout: null
        });
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
            <div class="row" style="margin-left: 50px">

                <div id="description">
                    <?php
                    if (!isset($content)) {
                        echo 'No content found.';
                    } else
                        echo '<h2>'.$content["sensor"]->name.'</h2>'.
                             '<ul><li>Location: TODO</li>'.
                             '<li>Catchment: '.$content["catchment"]->name.'</li>'.
                             '<li>Variable: TODO</li></ul>';

                        echo '<h2>Observations: </h2>';
                    ?>
                </div>
                <div id="graph"></div>

                <span id="range-btns-cont-1" class="btn-group range-btns-cont" style="visibility: visible;">
                    <button name="range-btn-5y" class="btn btn-default btn-mini">5y</button>
                    <button name="range-btn-3y" class="btn btn-default btn-mini">3y</button>
                    <button name="range-btn-2y" class="btn btn-default btn-mini">2y</button>
                    <button name="range-btn-1y" class="btn btn-default btn-mini">1y</button>
                    <button name="range-btn-ytd" class="btn btn-default btn-mini active">YTD</button>
                    <button name="range-btn-6m" class="btn btn-default btn-mini">6m</button>
                    <button name="range-btn-3m" class="btn btn-default btn-mini">3m</button>
                    <button name="range-btn-1m" class="btn btn-default btn-mini">1m</button>
                    <button name="range-btn-1w" class="btn btn-default btn-mini">1w</button>
                    <button name="range-btn-1d" class="btn btn-default btn-mini">1d</button>
                    <br>
                    <label class="radio-inline"><input type="radio" name="opt-line" checked>Line</label>
                    <label class="radio-inline"><input type="radio" name="opt-bar">Bar</label>
                </span>
            </div>
        </div>
    </div>

</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/2.1.0/dygraph.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/dygraph/2.1.0/dygraph.min.css" />
<script>
    // custom plotter, e.g. bar chart, see http://dygraphs.com/tests/plotters.html

    // Darken a color
    function darkenColor(colorStr) {
        // Defined in dygraph-utils.js
        var color = Dygraph.toRGB_(colorStr);
        color.r = Math.floor((255 + color.r) / 2);
        color.g = Math.floor((255 + color.g) / 2);
        color.b = Math.floor((255 + color.b) / 2);
        return 'rgb(' + color.r + ',' + color.g + ',' + color.b + ')';
    }

    // This function draws bars for a single series. See
    // multiColumnBarPlotter below for a plotter which can draw multi-series
    // bar charts.
    function barChartPlotter(e) {
        var ctx = e.drawingContext;
        var points = e.points;
        var y_bottom = e.dygraph.toDomYCoord(0);

        ctx.fillStyle = darkenColor(e.color);

        // Find the minimum separation between x-values.
        // This determines the bar width.
        var min_sep = Infinity;
        for (var i = 1; i < points.length; i++) {
            var sep = points[i].canvasx - points[i - 1].canvasx;
            if (sep < min_sep) min_sep = sep;
        }
        var bar_width = Math.floor(2.0 / 3 * min_sep);

        // Do the actual plotting.
        for (var i = 0; i < points.length; i++) {
            var p = points[i];
            var center_x = p.canvasx;

            ctx.fillRect(center_x - bar_width / 2, p.canvasy,
                bar_width, y_bottom - p.canvasy);

            ctx.strokeRect(center_x - bar_width / 2, p.canvasy,
                bar_width, y_bottom - p.canvasy);
        }
    }

    g = new Dygraph(
        document.getElementById("graph"),
        // data function which takes raw input from controller
        // and creates JS array with proper objects (e.g. x as Date())
        function() {
            var data = [];
            var rawData = <?php echo $content['data_points']?>;
            rawData.forEach(function(element) {
                data.push([new Date(element[0]), element[1]]);
            });

            return data;
        },
        {
            legend: 'always',
            animatedZooms: true,
            title: '',
            ylabel: 'Variable',
            labels: [ "date", "variable"],
            plotter: barChartPlotter,
            showRangeSelector: true
        });

</script>

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






