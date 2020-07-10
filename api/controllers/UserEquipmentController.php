<?php
namespace api\controllers;

use common\models\User;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;

class UserEquipmentController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                $user = User::findByUsername($username);
                if ($user && $user->validatePassword($password)) {
                    return $user;
                }
            }
        ];
        return $behaviors;
    }

    public $modelClass = 'common\models\UserEquipment';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions ?????
        // customize the data provider preparation with the "prepareDataProvider()" method

        return $actions;
    }

}