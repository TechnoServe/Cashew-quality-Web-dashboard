<?php

namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use backend\models\Qar;
use backend\models\Site;
use common\models\QarDetail;
use backend\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\validators\DateValidator;

class QarController extends ActiveController
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

    public $modelClass = 'common\models\Qar';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions ?????
        unset($actions['view']);
        // customize the data provider preparation with the "prepareDataProvider()" method

        return $actions;
    }

}