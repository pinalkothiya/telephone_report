<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_type".
 *
 * @property int $id
 * @property string $test_type
 * @property string $description
 * @property string $job_processing_table
 *
 * @property JobProcessingEcho[] $jobProcessingEchoes
 * @property JobProcessingFailover[] $jobProcessingFailovers
 * @property JobProcessing[] $jobProcessings
 * @property Job[] $jobs
 */
class TestType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_type', 'job_processing_table'], 'required'],
            [['test_type', 'description', 'job_processing_table'], 'string', 'max' => 255],
            [['test_type'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_type' => 'Test Type',
            'description' => 'Description',
            'job_processing_table' => 'Job Processing Table',
        ];
    }

    /**
     * Gets query for [[JobProcessingEchoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessingEchoes()
    {
        return $this->hasMany(JobProcessingEcho::className(), ['test_type_id' => 'id']);
    }

    /**
     * Gets query for [[JobProcessingFailovers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessingFailovers()
    {
        return $this->hasMany(JobProcessingFailover::className(), ['test_type_id' => 'id']);
    }

    /**
     * Gets query for [[JobProcessings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessings()
    {
        return $this->hasMany(JobProcessing::className(), ['test_type_id' => 'id']);
    }

    /**
     * Gets query for [[Jobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['test_type_id' => 'id']);
    }
}
