<?php
use yii\helpers\Html;

/* @var $content app\controllers\SiteController */
?>

<div class="observatory-content">
    <div id="description">
        <?php
        echo '<h2>'.$content["sensor"]->name.'</h2>'.
            '<ul><li>Location: TODO</li>'.
            '<li>Catchment: '.$content["catchment"]->name.'</li>'.
            '<li>Variable: TODO</li></ul>';

        echo '<h2>Observations: </h2>';
        ?>
    </div>
    <?php
    echo "<span style='float: left'> <label for=\"chart_type\">Chart type</label>". Html::dropDownList(
            'chart_type',
            $content['chart_type'],
            ['line' => 'Line', 'bar' => 'Bar'],
            [
                'id' => 'chart_type',
                'class' => 'form-control',
                'onchange'=>'
                    g.graph.updateOptions({ plotter: (this.value === \'bar\') ? barChartPlotter : null});'
            ])
        . "</span>";
    ?>
    <div id="graph"></div>
    <span id="range-btns-cont-1" class="btn-group range-btns-cont" style="visibility: visible;">
        <ul id="range-btns-list" style="list-style-type: none">
        <?php
        $time_spans = [
                '5y'=>'5 year',
                '3y'=>'3 year',
                '2y'=>'2 year',
                '1y'=>'1 year',
                'YTD'=>'ytd',
                '6m'=>'6 month',
                '3m'=>'3 month',
                '1m'=>'1 month',
                '1w'=>'1 week',
                '1d'=>'1 day'];
        foreach ($time_spans as $key => $value){
            $button_options = [
                'class' => 'btn btn-default btn-mini',
                'sensor_id' => $content['sensor']->id,
                'name' => 'range-btn-'.$key,
                'value' => $value
            ];
            echo "<li style='float: left'>" . Html::Button($key, $button_options) . "</li>";
        };
        ?>
        </ul>
    </span>
</div>

<script>
    function createGraph() {
        var pageCfg = {
            $graphCont: $('#graph'),
            $rangeBtnsCont: $("#range-btns-list")
        };
        return new JGS.Lineplot(pageCfg);
    }
    var g = createGraph();
    g.init();
</script>

