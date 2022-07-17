<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "number".
 *
 * @property int $id
 * @property int $company_id
 * @property string $number
 * @property int $country_code_id
 *
 * @property Company $company
 * @property CountryCode $countryCode
 * @property JobProcessingEcho[] $jobProcessingEchoes
 * @property JobProcessingFailover[] $jobProcessingFailovers
 * @property JobProcessing[] $jobProcessings
 */
class Number extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'number';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'number', 'country_code_id'], 'required'],
            [['company_id', 'country_code_id'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['company_id', 'country_code_id', 'number'], 'unique', 'targetAttribute' => ['company_id', 'country_code_id', 'number']],
            [['country_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryCode::className(), 'targetAttribute' => ['country_code_id' => 'id']],
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
            'number' => 'Number',
            'country_code_id' => 'Country Code ID',
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
     * Gets query for [[CountryCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountryCode()
    {
        return $this->hasOne(CountryCode::className(), ['id' => 'country_code_id']);
    }

    /**
     * Gets query for [[JobProcessingEchoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessingEchoes()
    {
        return $this->hasMany(JobProcessingEcho::className(), ['number_id' => 'id']);
    }

    /**
     * Gets query for [[JobProcessingFailovers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessingFailovers()
    {
        return $this->hasMany(JobProcessingFailover::className(), ['number_id' => 'id']);
    }

    /**
     * Gets query for [[JobProcessings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobProcessings()
    {
        return $this->hasMany(JobProcessing::className(), ['number_id' => 'id']);
    }
}
