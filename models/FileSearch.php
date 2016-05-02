<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\File;

/**
* FileSearch represents the model behind the search form about `app\models\File`.
*/
class FileSearch extends File
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'sensorid'], 'integer'],
            [['filelink', 'filename', 'extension', 'startdate', 'enddate', 'status'], 'safe'],
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
$query = File::find();

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
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
            'sensorid' => $this->sensorid,
        ]);

        $query->andFilterWhere(['like', 'filelink', $this->filelink])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'extension', $this->extension])
            ->andFilterWhere(['like', 'status', $this->status]);

return $dataProvider;
}
}