<?php
use yii\helpers\Html;
use yii\web\View;
use app\models\Sensor;
use app\models\Catchment;
?>
            <div class='row' style='max-width: 90%; max-height: 90%;'>
                <div class='col-sm-12'>
                            <?php 
                            $locationarray=[];
                            foreach ($locations as $loc) {
                                $locationarray[$loc->id] = htmlspecialchars($loc->name);
                            }
                            echo Html::dropDownList('locationlist', $location->id, $locationarray, array('id' => 'locationlist')); 
                            ?>
                        <p id='catchmentdescription'><?php echo htmlspecialchars($location->description); ?></p>
                </div>
                <div class='col-sm-6 col-xs-12'>
                        <img src="<?php echo Yii::getAlias('@web'); ?>/images/photos/catchmentmap.png" class='img-responsive'>
                </div>
                <div class='col-sm-6 col-xs-12'>
                        <h3>List of Sensors:</h3>
                        <ul id="sensorslist">
                            <?php
                            foreach ($location->sensors as $sensor) {
                                echo "<li>";
                                echo html::a($sensor->name, ['/site/sensor', 'sensorid' => $sensor->id]);
                                echo "</li>";
                            }
                            ?>
                        </ul>
                </div>
            </div>
