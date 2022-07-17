<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property int $id
 * @property int $company_id
 * @property int $test_type_id
 * @property string $name
 * @property string $start_time
 *
 * @property Company $company
 * @property JobProcessingEcho[] $jobProcessingEchoes
 * @property JobProcessingFailover[] $jobProcessingFailovers
 * @property JobProcessing[] $jobProcessings
 * @property TestType $testType
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'test_type_id', 'name'], 'required'],
            [['company_id', 'test_type_id'], 'integer'],
            [['start_time'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['test_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestType::className(), 'targetAttribute' => ['test_type_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'test_type_id' => 'Test Type ID',
            'name' => 'Name',
            'start_time' => 'Start Time',
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * Gets query for [[JobProcessingEchoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessingEchoes()
    {
        return $this->hasMany(JobProcessingEcho::className(), ['job_id' => 'id']);
    }

    /**
     * Gets query for [[JobProcessingFailovers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessingFailovers()
    {
        return $this->hasMany(JobProcessingFailover::className(), ['job_id' => 'id']);
    }

    /**
     * Gets query for [[JobProcessings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessings()
    {
        return $this->hasMany(JobProcessing::className(), ['job_id' => 'id']);
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
