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
    <div id="graph"></div>

    <span id="range-btns-cont-1" class="btn-group range-btns-cont" style="visibility: visible;">
        <button class="range-btns-toggle collapsed btn" data-toggle="collapse" data-target="#range-btns-list">
            Options
        </button>

        <ul id="range-btns-list" class="collapse" style="list-style-type: none">
        <?php
        $time_spans = [
                'All'=>'all',
                '5y'=>'5 years',
                '3y'=>'3 years',
                '2y'=>'2 years',
                '1y'=>'1 year',
                '6m'=>'6 months',
                '3m'=>'3 months',
                '1m'=>'1 month',
                '1w'=>'1 week',
                '1d'=>'1 day'];
        foreach ($time_spans as $key => $value){
            $button_options = [
                'class' => 'btn btn-default btn-mini',
                'onclick'=>'fetchTSData('.$content['sensor']->id.', this.value, $("#chart_type :selected")[0].value)',
                'name' => 'range-btn-'.$key,
                'value' => $value
            ];
            if ($content["time_span"] === $value) {
                Html::addCssClass($button_options, 'active');
            }
            echo "<li style='float: left'>" . Html::Button($key, $button_options) . "</li>";
        };

        echo "<li style='float: left'>" . Html::dropDownList('chart_type', $content['chart_type'], ['line' => 'Line', 'bar' => 'Bar'], [
                'id' => 'chart_type',
                'class' => 'form-control',
                'onchange'=>'g.updateOptions({ plotter: (this.value === \'bar\') ? multiColumnBarPlotter : null});'
            ]) . "</li>";
        ?>
        </ul>
    </span>
</div>

<script>
    var chartType = '<?= $content['chart_type']?>';
    var rawData = <?= $content['data_points']?>;
    gData = getDygraphData(rawData);
    createDygraph(gData,chartType);

    $(window).resize(function() {
        gData = getDygraphData(rawData);
        g.updateOptions({file: gData});
    });
</script>

