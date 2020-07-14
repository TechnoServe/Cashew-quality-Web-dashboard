<?php

namespace backend\models;

use Yii;

class User extends \common\models\User
{

    const ROLE_ADMIN = 1;

    const ROLE_ADMIN_VIEW = 2;

    const ROLE_INSTITUTION_ADMIN = 3;

    const ROLE_INSTITUTION_ADMIN_VIEW = 4;

    const ROLE_FIELD_TECH = 5;

    const ROLE_FIELD_BUYER = 6;

    const ROLE_FIELD_FARMER = 7;


    /**
     * Query users by company
     * @return \yii\db\ActiveQuery
     */
    public static function queryByCompany(){
        $loggedInUser = Yii::$app->user->identity;

        if($loggedInUser->role != self::ROLE_ADMIN && $loggedInUser->role != self::ROLE_ADMIN_VIEW)
            return self::find()->where(["company_id" =>  $loggedInUser->company_id]);

        return self::find();
    }


    public static function getUserRole()
    {
        return [
            self::ROLE_ADMIN => Yii::t('app', 'Top Admin'),
            self::ROLE_ADMIN_VIEW => Yii::t('app', 'Top Admin View'),
            self::ROLE_INSTITUTION_ADMIN => Yii::t('app', 'Institution Admin'),
            self::ROLE_INSTITUTION_ADMIN_VIEW => Yii::t('app', 'Institution Admin View'),
            self::ROLE_FIELD_TECH => Yii::t('app', 'Field Tech'),
            self::ROLE_FIELD_BUYER => Yii::t('app', 'Buyer'),
            self::ROLE_FIELD_FARMER => Yii::t('app', 'Farmer'),
        ];
    }


    public static function getUserRoleConsideringCurrentUser()
    {
        $currentUser = Yii::$app->user->identity;

        if ($currentUser->role == self::ROLE_ADMIN) {
            return [
                self::ROLE_ADMIN => Yii::t('app', 'Top Admin'),
                self::ROLE_ADMIN_VIEW => Yii::t('app', 'Top Admin View'),
                self::ROLE_INSTITUTION_ADMIN => Yii::t('app', 'Institution Admin'),
            ];
        }

        if ($currentUser->role == self::ROLE_INSTITUTION_ADMIN) {
            return [
                self::ROLE_INSTITUTION_ADMIN => Yii::t('app', 'Institution Admin'),
                self::ROLE_INSTITUTION_ADMIN_VIEW => Yii::t('app', 'Institution Admin View'),
                self::ROLE_FIELD_TECH => Yii::t('app', 'Field Tech'),
                self::ROLE_FIELD_BUYER => Yii::t('app', 'Buyer'),
                self::ROLE_FIELD_FARMER => Yii::t('app', 'Farmer'),
            ];
        }

        return [];
    }

    /**
     * Prepares select2 values for form
     *
     * @param $attribute
     * @param $userRole
     * @param $html_id
     * @param $placeholder
     *
     * @return array
     */
    public static function getUsersSelectWidgetValues(
        $attribute,
        $userRole,
        $html_id,
        $placeholder
    ) {
        if ($userRole) {
            $activeUsers = self::queryByCompany()
                ->andWhere(["status" => User::STATUS_ACTIVE])
                ->andWhere(["role" => $userRole])
                ->all();
        } else {
            $activeUsers = self::find()
                ->where(["status" => User::STATUS_ACTIVE])
                ->all();
        }

        $data = [];

        foreach ($activeUsers as $user) {
            $data[$user->id] = $user->first_name." ".$user->middle_name." ".$user->last_name;
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

    public static function getLanguagesDropDownList()
    {
        return [
            "en" => "English",
            "fr" => "Français",
            "pt" => " Português",
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


    /**
     * Clean input data to ensure data validation
     */
    public function purifyInput(){

        $currentUser = Yii::$app->user->identity;

        $allowedRoles = self::getUserRoleConsideringCurrentUser();

        if(!array_key_exists($this->role, $allowedRoles))
            $this->role = null;

        if($currentUser->role != User::ROLE_ADMIN && $currentUser->role != User::ROLE_ADMIN_VIEW)
            $this->company_id = $currentUser->company_id;
    }
}