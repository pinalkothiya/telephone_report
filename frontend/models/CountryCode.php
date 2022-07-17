<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "country_code".
 *
 * @property int $id
 * @property string $country_code
 * @property string $country_name
 * @property string $country_prefix
 *
 * @property Number[] $numbers
 */
class CountryCode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country_code';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_code', 'country_name'], 'required'],
            [['country_code'], 'string', 'max' => 3],
            [['country_name'], 'string', 'max' => 255],
            [['country_prefix'], 'string', 'max' => 10],
            [['country_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_code' => 'Country Code',
            'country_name' => 'Country Name',
            'country_prefix' => 'Country Prefix',
        ];
    }

    /**
     * Gets query for [[Numbers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNumbers()
    {
        return $this->hasMany(Number::className(), ['country_code_id' => 'id']);
    }

     /**
     * Gets company list.
     *
     * @return Array
     */
    public function getCountryList(){
        $countryList = CountryCode::find()->select(['id', 'country_name'])->orderBy('country_name')->all();
        $countryListArray = ArrayHelper::map($countryList, 'id', 'country_name');
        return $countryListArray;
    }
}
