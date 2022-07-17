<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job_processing".
 *
 * @property int $id
 * @property int $test_type_id
 * @property int $job_id
 * @property int $number_id
 * @property string $call_start_time
 * @property string $call_connect_time
 * @property string $call_end_time
 * @property int|null $call_description_id
 * @property string $created_on
 * @property string $updated_on
 *
 * @property CallDescription $callDescription
 * @property Job $job
 * @property Number $number
 * @property TestType $testType
 */
class JobProcessing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_processing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_type_id', 'job_id', 'number_id'], 'required'],
            [['test_type_id', 'job_id', 'number_id', 'call_description_id'], 'integer'],
            [['call_start_time', 'call_connect_time', 'call_end_time', 'created_on', 'updated_on'], 'safe'],
            [['call_description_id'], 'exist', 'skipOnError' => true, 'targetClass' => CallDescription::className(), 'targetAttribute' => ['call_description_id' => 'id']],
            [['number_id'], 'exist', 'skipOnError' => true, 'targetClass' => Number::className(), 'targetAttribute' => ['number_id' => 'id']],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => Job::className(), 'targetAttribute' => ['job_id' => 'id']],
            [['test_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestType::className(), 'targetAttribute' => ['test_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_type_id' => 'Test Type ID',
            'job_id' => 'Job ID',
            'number_id' => 'Number ID',
            'call_start_time' => 'Call Start Time',
            'call_connect_time' => 'Call Connect Time',
            'call_end_time' => 'Call End Time',
            'call_description_id' => 'Call Description ID',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        ];
    }

    /**
     * Gets query for [[CallDescription]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCallDescription()
    {
        return $this->hasOne(CallDescription::className(), ['id' => 'call_description_id']);
    }

    /**
     * Gets query for [[Job]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }

    /**
     * Gets query for [[Number]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNumber()
    {
        return $this->hasOne(Number::className(), ['id' => 'number_id']);
    }

    /**
     * Gets query for [[TestType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTestType()
    {
        return $this->hasOne(TestType::className(), ['id' => 'test_type_id']);
    }
}
