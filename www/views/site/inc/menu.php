                        <?php 
                        use kartik\sidenav\SideNav;
                        use yii\helpers\Url;
                        $sensorid = isset($sensor)?$sensor->id:null;
                        echo SideNav::widget([
                            'type' => SideNav::TYPE_DEFAULT,
                            'heading' => null,
                            'encodeLabels' => false,
                            'items' => [
                                [
                                    'url' => Url::to(['site/sensor', 'sensorid' => $sensorid]),
                                    'label' => \Yii::t('menu', 'Sensor info'),
                                    'icon' => 'filter', 
                                    'active' => (Yii::$app->controller->action->id == 'sensor'),
                                    'visible' => Yii::$app->controller->action->id != 'observatory',
                                ],
                                [
                                    'url' => Url::to(['site/maps', 'sensorid' => $sensorid]),
                                    'label' => \Yii::t('menu', 'Maps'),
                                    'icon' => 'map-marker', 
                                    'active' => (Yii::$app->controller->action->id == 'maps'),
                                    'visible' => Yii::$app->controller->action->id != 'observatory',
                                ],
                                [
                                    'url' => Url::to(['site/riverflow', 'sensorid' => $sensorid]),
                                    'label' => \Yii::t('menu', 'Riverflow'),
                                    'icon' => 'tint',
                                    'active' => (Yii::$app->controller->action->id == 'riverflow'),
                                    'visible' => Yii::$app->controller->action->id != 'observatory',
                                ],
                                [
                                    'url' => Url::to(['site/rainfall', 'sensorid' => $sensorid]),
                                    'label' => \Yii::t('menu', 'Rainfall'),
                                    'icon' => 'cloud-download',
                                    'active' => (Yii::$app->controller->action->id == 'rainfall'),
                                    'visible' => Yii::$app->controller->action->id != 'observatory',
                                ],
                                [
                                    'url' => Url::to(['site/temperature', 'sensorid' => $sensorid]),
                                    'label' => \Yii::t('menu', 'Temperature'),
                                    'icon' => 'sunglasses',
                                    'active' => (Yii::$app->controller->action->id == 'temperature'),
                                    'visible' => Yii::$app->controller->action->id != 'observatory',
                                ],
                                [
                                    'url' => Url::to(['site/tracing', 'sensorid' => $sensorid]),
                                    'label' => \Yii::t('menu', 'Tracing'),
                                    'icon' => 'stats',
                                    'active' => (Yii::$app->controller->action->id == 'tracing'),
                                    'visible' => Yii::$app->controller->action->id != 'observatory',
                                ],
                                [
                                    'url' => Url::to(['site/addsensor']),
                                    'label' => '<button class="btn btn-default">'.\Yii::t('menu', 'Add Sensor').'</button>',
                                    'icon' => null,
                                    'options' => array('class'=>'menu-buttons'),
                                ],
                                [
                                    'url' => Url::to(['site/uploaddata', 'sensorid' => $sensorid]),
                                    'label' => '<button class="btn btn-default">'.\Yii::t('menu', 'Upload Data').'</button>',
                                    'icon' => null,
                                    'options' => array('class'=>'menu-buttons'),
                                    'visible' => Yii::$app->controller->action->id != 'observatory',
                                ],
                            ],
                        ]);
                        ?>