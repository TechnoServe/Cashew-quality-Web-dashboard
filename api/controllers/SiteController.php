<?php
namespace api\controllers;

use common\models\User;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;

class SiteController extends Controller
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

        return array_merge(
            $behaviors,
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => [
                                User::ROLE_FIELD_TECH,
                                User::ROLE_FIELD_BUYER
                            ],
                        ],

                    ],
                ],]);
    }

    public function actionIndex(){
        return "WELCOME TO CNQA API";
    }
}