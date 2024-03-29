<?php

namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use backend\models\User;
use api\models\ChangePassword;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\Controller;

class UserController extends Controller
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
        return array_merge($behaviors,
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['change-password', 'save-token', 'view'],
                            'allow' => true,
                            'roles' => [User::ROLE_FIELD_TECH, User::ROLE_FIELD_BUYER],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'change-password' => ['POST'],
                        'save-token' => ['PATCH'],
                        'login' => ['POST'],
                    ],
                ],
            ]);
    }


    /**
     * Get details of a specific user
     * @param $id
     * @return ApiResponse
     */
    public function actionView($id = null)
    {

        $user = \api\models\User::queryByCompany(Yii::$app->user->identity)->andWhere(["id" => $id])->one();
        if (!empty($user)) {
            return new ApiResponse($user, null, true);
        }

        Yii::$app->response->statusCode = 404;
        return new ApiResponse(null, [new ApiError("INVALID DATA", "User not found")], true);
    }

    /**
     * Accepts request to change an existing password, knowing the current password
     * @return ApiResponse
     */
    public function actionChangePassword()
    {
        $data = Yii::$app->request->post();
        $model = new ChangePassword();
        $errors = [];

        if (!isset($data['current_password']) || empty($data['current_password']))
            array_push($errors, new ApiError(ApiError::INVALID_DATA, "Current password must be provided"));

        if (!isset($data['new_password']) || empty($data['new_password']))
            array_push($errors, new ApiError(ApiError::INVALID_DATA, "New password must be provided"));

        if (!isset($data['password_repeat']) || empty($data['password_repeat']))
            array_push($errors, new ApiError(ApiError::INVALID_DATA, "Password confirmation is not provided"));

        if (!empty($errors)) {
            Yii::$app->response->statusCode = 400;
            return new ApiResponse([], $errors, false);
        }

        $model->current_password = $data['current_password'];
        $model->new_password = $data['new_password'];
        $model->password_repeat = $data['password_repeat'];
        $model->_user = Yii::$app->user->getIdentity();

        if ($model->validate() && $model->resetPassword()) {
            return new ApiResponse([], null, true);
        }

        Yii::$app->response->statusCode = 400;
        return new ApiResponse([], [new ApiError(ApiError::INVALID_DATA, "Password could not be changed")], false);
    }


//    /**
//     * Takes in  an email and send password reset email
//     * @return ApiResponse
//     */
//    public function actionPasswordReset()
//    {
//        $data = Yii::$app->request->post();
//        $model = new PasswordResetRequestForm();
//
//        if (!isset($data['email']) || empty($data['email']))
//            return new ApiResponse([], [new ApiError(ApiError::INVALID_DATA, "Email has to be provided")], false);
//
//        $model->email = $data["email"];
//
//        if ($model->validate() && $model->sendEmail(Yii::$app->params["BACKEND_BASE_URL"])) {
//            return new ApiResponse([], null, true);
//        }
//        Yii::$app->response->statusCode = 400;
//        return new ApiResponse([], [new ApiError(ApiError::INVALID_DATA, "Password could not be changed")], false);
//    }


    /**
     * Helps to capture user expo notification token
     * @return ApiResponse
     * @throws \yii\db\Exception
     */
    public function actionSaveToken()
    {
        $data = Yii::$app->request->post();

        $errors = [];

        $user = \api\models\User::findOne(Yii::$app->getUser()->getId());

        if (!array_key_exists("token",$data)) {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Please provide token"));
        }

        // If validation
        if (!empty($errors)) {
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, $errors, false);
        }

        try {
            $user->expo_token = $data['token'];
            $user->save(false);
        } catch (\Exception $exception) {
            return new ApiResponse(null, [new ApiError(ApiError::INVALID_DATA, $exception->getMessage())], false);
        }

        return new ApiResponse($user, null, true);
    }
}