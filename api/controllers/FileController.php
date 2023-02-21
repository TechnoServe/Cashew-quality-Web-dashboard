<?php
namespace api\controllers;


use api\models\User;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class FileController extends Controller
{
    public $email;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors["authenticator"] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                $user = User::findByUsername($username);
                if ($user && $user->validatePassword($password)) {
                    return $user;
                }
                return null;
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
                ],
            ]
        );
    }

    public function actionDownload($folder , $filename) {

        $storagePath = Yii::getAlias('@backend/web/uploads');
        $imgFullPath = $storagePath . "/". $folder . "/". $filename;
       
        if (file_exists($imgFullPath)) {
            return Yii::$app->response->sendFile($imgFullPath, null, ['inline' => true]);
        }

        throw new NotFoundHttpException('The file does not exists.');
    }
}
