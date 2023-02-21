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
            'id' => Yii::t("app",'ID'),
            'country_code' => Yii::t("app",'Country Code'),
            'name' => Yii::t("app",'Name'),
            'postal_code' => Yii::t("app",'Postal Code'),
            'created_at' => Yii::t("app",'Created At'),
            'updated_at' => Yii::t("app",'Updated At'),
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
