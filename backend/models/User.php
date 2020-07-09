<?php

namespace backend\models;

use Yii;

class User extends \common\models\User
{


    /**
     * Prepares select2 values for form
     * @param $attribute
     * @param $userRole
     * @param $html_id
     * @param $placeholder
     *
     * @return array
     */
    public static function getUsersSelectWidgetValues($attribute, $userRole, $html_id, $placeholder)
    {
        if($userRole){
            $activeUsers = self::find()
                ->where(["status" => User::STATUS_ACTIVE])
                ->andWhere(["role" => $userRole])
                ->all();
        }else {
            $activeUsers = self::find()
                ->where(["status" => User::STATUS_ACTIVE])
                ->all();
        }

        $data = [];

        foreach ($activeUsers as $user){
            $data[$user->id] = $user->first_name . " " . $user->middle_name . " " . $user->last_name;
        }

        return [
            'data' => $data,
            'attribute' => $attribute,
            'language' => Yii::$app->language,
            'options' => ['id' => $html_id, 'placeholder' => $placeholder],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ];

    }

    public static function getLanguagesDropDownList()
    {
        return [
            "en" => "English",
            "fr" => "Français",
            "pt" => " Português"
        ];
    }

    /**
     * Gets query for [[UserEquipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserEquipments()
    {
        return $this->hasMany(UserEquipment::className(), ['id_user' => 'id']);
    }
}