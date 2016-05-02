<?php

namespace app\models;

use Yii;
use \app\models\base\Catchment as BaseCatchment;

/**
 * This is the model class for table "catchment".
 */
class Catchment extends BaseCatchment
{

	function getName(){
		$name = $this->name;
		switch (\Yii::$app->language) {
			case 'es':
				if (isset($this->name_es) && $this->name_es != ''){
					$name = $this->name_es;
				}
				break;
			case 'ne':
				if (isset($this->name_ne) && $this->name_ne != ''){
					$name = $this->name_ne;
				}
				break;
		}
		return $name;
	}

	function getDescription(){
		$description = $this->description;
		switch (\Yii::$app->language) {
			case 'es':
				if (isset($this->description_es) && $this->description_es != ''){
					$description = $this->description_es;
				}
				break;
			case 'ne':
				if (isset($this->description_ne) && $this->description_ne != ''){
					$description = $this->description_ne;
				}
				break;
		}
		return $description;
	}

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
	        [
	            'name_es' => Yii::t('catchment', 'Name (Spanish)'),
	            'name_ne' => Yii::t('catchment', 'Name (Nepali)'),
	            'description_es' => Yii::t('catchment', 'Description (Spanish)'),
	            'description_ne' => Yii::t('catchment', 'Description (Nepali)'),
	        ]);
    }


}
