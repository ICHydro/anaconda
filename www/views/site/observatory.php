<?php

use execut\widget\TreeView;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use yii\helpers\Url;

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
    $state = ['expanded' => false];
    $location_entry = ['text' => $location, 'nodes' => $children, 'href' => Url::to(['']), 'state' => $state];
    array_push($data, $location_entry);
}

$onSelect = new JsExpression(<<<JS
function (undefined, item) {
    if (item.sensor_id){
     $.pjax({
        container: '#content',
        timeout: null,
        url: 'observatory',
        type: 'POST',
        data: {"sensor_id": item.sensor_id}
    });
    }
    else{
        $.pjax({
        container: 'div #content',
        timeout: null,
        url: 'observatory',
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

<!-- need for a row here?? -->

 <div class="col-lg-3 col-xs-2 col-sm-2 sidenav-widget" id="left">
                <div class="locations-tree-view">
                    <h2>Locations</h2>
                    <!-- treeview widget from yii2-widget-bootstraptreeview -->
                    <div id="w0"></div>
		</div>
 </div>
 

  <div class="col-lg-9 col-sm-10 col-xs-10" id="content">
      <div id="graph"></div>

            <?php
            if (isset($content)){
                echo $this->render('observatory_content', ['content' => $content]);
                $map_source = '';
            }
            else{
                echo $this->render('observatory_map', [
                        'map_center' => $map_center,
                        'tree_data' => $tree_data
                ]);
            }
            ?>
   </div>  


<script>
  function getCSRF() {return  '<?=Yii::$app->request->getCsrfToken()?>'}
</script>




