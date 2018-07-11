<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "observations".
 *
 * @property integer $obs_id
 * @property string $value
 * @property string $timestamp
 * @property integer $var_id
 * @property integer $sensor_id
 * @property integer $unit_id
 * @property integer $file_id
 *
 * @property Files $file
 * @property Sensors $sensor
 * @property Units $unit
 * @property Variables $var
 */
class Observation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'observations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'timestamp'], 'required'],
            [['value'], 'number'],
            [['timestamp'], 'safe'],
            [['var_id', 'sensor_id', 'unit_id', 'file_id'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'file_id']],
            [['sensor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sensors::className(), 'targetAttribute' => ['sensor_id' => 'sensor_id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::className(), 'targetAttribute' => ['unit_id' => 'unit_id']],
            [['var_id'], 'exist', 'skipOnError' => true, 'targetClass' => Variables::className(), 'targetAttribute' => ['var_id' => 'var_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'obs_id' => 'Obs ID',
            'value' => 'Value',
            'timestamp' => 'Timestamp',
            'var_id' => 'Var ID',
            'sensor_id' => 'Sensor ID',
            'unit_id' => 'Unit ID',
            'file_id' => 'File ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['file_id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSensor()
    {
        return $this->hasOne(Sensors::className(), ['sensor_id' => 'sensor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Units::className(), ['unit_id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVar()
    {
        return $this->hasOne(Variables::className(), ['var_id' => 'var_id']);
    }
}
