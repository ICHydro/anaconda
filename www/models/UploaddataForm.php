<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Calibration;
use app\models\File;
use yii\web\UploadedFile;



/**
 */
class UploaddataForm extends Model
{
    public $id;
    public $catchmentid;
    public $sensorid;
    public $date;
    public $reading;
    public $yourname;
    public $youremail;
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['sensorid', 'date'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            [['file', 'id', 'catchmentid', 'reading', 'yourname', 'youremail'], 'safe'],
            [['file'], 'file', 'extensions'=>'txt, csv, xls, xlsx'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            
        ];
    }

    public function save(){
        if (isset($this->reading) and $this->reading != ''){
            $savemodel = new Calibration;
            $savemodel->measure = 'mm';
            $savemodel->height = $this->reading;
            $savemodel->sensorid = $this->sensorid;
            $savemodel->datetime = $this->date;
            $savemodel->youremail = $this->youremail;
            $savemodel->yourname = $this->yourname;
            $result = $savemodel->save();
            $this->id = $savemodel->sensorid;
            return $result;
        }else {
            $savemodel = new File;
            $savemodel->sensorid = $this->sensorid;
            $savemodel->startdate = $this->date;
            $savemodel->enddate = $this->date;
            $savemodel->status = 'processed';
            $this->file = UploadedFile::getInstance($this, 'file');
            $savemodel->extension = end((explode(".", $this->file->name)));
            $result = $savemodel->save(); // save to get the ID
            $savemodel->filename = $savemodel->id."_".$this->file->name;
            $path = Yii::getAlias('@app').Yii::$app->params['uploadPath'] . $savemodel->filename;
            if ($result){
                $this->file->saveAs($path);
            }
            $result = $savemodel->save();
            $this->id = $savemodel->sensorid;
            return $result;
        }
    }
}
