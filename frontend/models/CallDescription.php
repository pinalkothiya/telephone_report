<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "call_description".
 *
 * @property int $id
 * @property string $description
 *
 * @property JobProcessingEcho[] $jobProcessingEchoes
 * @property JobProcessingFailover[] $jobProcessingFailovers
 * @property JobProcessing[] $jobProcessings
 */
class CallDescription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call_description';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'string', 'max' => 255],
            [['description'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[JobProcessingEchoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessingEchoes()
    {
        return $this->hasMany(JobProcessingEcho::className(), ['call_description_id' => 'id']);
    }

    /**
     * Gets query for [[JobProcessingFailovers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessingFailovers()
    {
        return $this->hasMany(JobProcessingFailover::className(), ['call_description_id' => 'id']);
    }

    /**
     * Gets query for [[JobProcessings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessings()
    {
        return $this->hasMany(JobProcessing::className(), ['call_description_id' => 'id']);
    }
}
