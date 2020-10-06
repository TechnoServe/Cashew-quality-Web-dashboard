<?php


namespace api\controllers;


use api\components\ApiError;
use api\components\ApiResponse;
use backend\models\Company;
use api\models\User;
use backend\models\UserEquipment;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;

class PublicController extends Controller
{

    public function behaviors()
    {
        return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['login'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'login' => ['POST'],
                    ],
                ],
            ];
    }


    public function actionLogin(){

        $data = Yii::$app->request->post();

        // Check for username
        if(!$this->keyIsNotEmptyInArray($data, "username")){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, [new ApiError(ApiError::EMPTY_DATA, "Username has to be provided")], false);
        }

        // Check for password
        if(!$this->keyIsNotEmptyInArray($data, "password")){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, [new ApiError(ApiError::EMPTY_DATA, "Username has to be provided")], false);
        }

        $user = User::findByUsername($data["username"]);

        if(empty($user) || !$user->validatePassword($data["password"])){
            throw new UnauthorizedHttpException("Invalid credentials");
        }

        $userArray = $user->toArray();
        $userArray["company_details"] = Company::findOne($user->company_id);
        $user->role == User::ROLE_FIELD_TECH ?  $userArray["equipments"] = UserEquipment::find()->where(['id_user' => $user->id])->asArray()->all() : null;

        return new ApiResponse($userArray, null, true);
    }

    /**
     * Check whether a key is valid and existent in an array
     * @param $array
     * @param $key
     * @return bool
     */
    private function keyIsNotEmptyInArray($array, $key){
        return isset($array[$key]) && !empty($array[$key]);
    }

}