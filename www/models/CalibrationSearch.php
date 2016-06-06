<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calibration;

/**
* CalibrationSearch represents the model behind the search form about `app\models\Calibration`.
*/
class CalibrationSearch extends Calibration
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'sensorid'], 'integer'],
            [['datetime', 'measure', 'yourname', 'youremail'], 'safe'],
            [['height'], 'number'],
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
$query = Calibration::find();

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
            'datetime' => $this->datetime,
            'height' => $this->height,
            'sensorid' => $this->sensorid,
        ]);

        $query->andFilterWhere(['like', 'measure', $this->measure])
            ->andFilterWhere(['like', 'yourname', $this->yourname])
            ->andFilterWhere(['like', 'youremail', $this->youremail]);

return $dataProvider;
}
}