<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 *
 * @property Job[] $jobs
 * @property Number[] $numbers
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Jobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Numbers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNumbers()
    {
        return $this->hasMany(Number::className(), ['company_id' => 'id']);
    }

     /**
     * Gets company list.
     *
     * @return Array
     */
    public function getCompanyList(){
        $companyList = Company::find()->select(['id', 'name'])->orderBy('name')->all();
        $companyListArray = ArrayHelper::map($companyList, 'id', 'name');
        return $companyListArray;
    }
}
