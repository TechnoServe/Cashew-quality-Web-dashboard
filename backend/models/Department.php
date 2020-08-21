<?php

namespace backend\models;

use common\helpers\CashewAppHelper;
use Yii;

/**
 * This is the model class for table "departments".
 *
 * @property int $id
 * @property string $country_code
 * @property string $name
 * @property string|null $postal_code
 * @property string $created_at
 * @property string $updated_at
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_code', 'name', 'postal_code'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['country_code', 'postal_code'], 'string', 'max' => 2],
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
            'country_code' => 'Country Code',
            'name' => 'Name',
            'postal_code' => 'Postal Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Department dropdown values for select2
     *
     * @param $attribute
     * @param $html_id
     * @param $placeholder
     *
     * @return array
     */
    public static function getDepartmentsSelectWidgetValues($attribute, $html_id, $placeholder)
    {

        $departments = self::find()->all();

        $data = [];

        foreach ($departments as $department) {
            $data[$department->id] = CashewAppHelper::getListOfCountries()[$department->country_code] . " [" . $department->country_code  . "]" .  " • " . $department->name . " [" . $department->postal_code . "]";
        }

        return [
            'data' => $data,
            'attribute' => $attribute,
            'language' => Yii::$app->language,
            'options' => ['id' => $html_id, 'placeholder' => $placeholder],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ];
    }
    
}
