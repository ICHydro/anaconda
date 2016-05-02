<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Catchment;

/**
* CatchmentSearch represents the model behind the search form about `app\models\Catchment`.
*/
class CatchmentSearch extends Catchment
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id'], 'integer'],
            [['name', 'name_es', 'name_ne', 'description', 'description_es', 'description_ne'], 'safe'],
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
$query = Catchment::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_es', $this->name_es])
            ->andFilterWhere(['like', 'name_ne', $this->name_ne])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'description_es', $this->description_es])
            ->andFilterWhere(['like', 'description_ne', $this->description_ne]);

return $dataProvider;
}
}