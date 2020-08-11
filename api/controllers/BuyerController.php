<?php

namespace api\controllers;

use backend\models\Qar;
use common\models\QarDetail;
use common\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\filters\auth\QueryParamAuth;


class BuyerController extends ActiveController
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

    public $modelClass = 'common\models\User';
    // Some reserved attributes like maybe 'q' for searching all fields at once 
    // or 'sort' which is already supported by Yii RESTful API
   // public $reservedParams = ['sort','q'];

    public function actions()
    {
        $actions = parent::actions();
      //  $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
       // unset($actions['view']);
        return $actions;
    }


}