<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sensor;

/**
* SensorSearch represents the model behind the search form about `app\models\Sensor`.
*/
class SensorSearch extends Sensor
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'catchmentid'], 'integer'],
            [['name', 'sensortype', 'units', 'property', 'admin_email'], 'safe'],
            [['latitude', 'longitude', 'height', 'width', 'angle'], 'number'],
];
}

/**
* @inheritdoc
*/
public function scenarios()
{
// bypass scenarios() implementation in the parent class
return Model::scenarios();
}

/**
* Creates data provider instance with search query applied
*
* @param array $params
*
* @return ActiveDataProvider
*/
public function search($params)
{
$query = Sensor::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'id' => $this->id,
            'catchmentid' => $this->catchmentid,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'height' => $this->height,
            'width' => $this->width,
            'angle' => $this->angle,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sensortype', $this->sensortype])
            ->andFilterWhere(['like', 'units', $this->units])
            ->andFilterWhere(['like', 'property', $this->property])
            ->andFilterWhere(['like', 'admin_email', $this->admin_email]);

return $dataProvider;
}
}