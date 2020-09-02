<?php

namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use backend\models\User;
use api\models\ChangePassword;
use backend\models\form\PasswordResetRequestForm;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\filters\AccessControl;

class UserController extends ActiveController
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
                            'actions' => ['password-reset', 'save-token'],
                            'allow' => true,
                        ],

                        [
                            'actions' => ['change-password'],
                            'allow' => true,
                            'roles' => [User::ROLE_FIELD_TECH, User::ROLE_FIELD_FARMER, User::ROLE_FIELD_BUYER],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'password-reset' => ['POST'],
                        'change-password' => ['POST'],
                        'save-token' => ['POST'],
                    ],
                ],
            ]);

    }

    public $modelClass = 'api\models\User';


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


    /**
     * Takes in  an email and send password reset email
     * @return ApiResponse
     */
    public function actionPasswordReset()
    {
        $data = Yii::$app->request->post();
        $model = new PasswordResetRequestForm();

        if (!isset($data['email']) || empty($data['email']))
            return new ApiResponse([], [new ApiError(ApiError::INVALID_DATA, "Email has to be provided")], false);

        $model->email = $data["email"];

        if ($model->validate() && $model->sendEmail(Yii::$app->params["BACKEND_BASE_URL"])) {
            return new ApiResponse([], null, true);
        }
        Yii::$app->response->statusCode = 400;
        return new ApiResponse([], [new ApiError(ApiError::INVALID_DATA, "Password could not be changed")], false);
    }

    public function actionSaveToken()
    {
        $data = Yii::$app->request->post();

        $user = new User();

        $errors = [];

        if (isset($data['user_id']) && !empty($data['user_id'])) {
            $userExists = User::queryByCompany()->andWhere([
                "id" => $data['user_id']
            ])->exists();
            if ($userExists) {
                if (isset($data['token']) && !empty($data['token'])) {
                    $user->expo_token = $data['token'];

                     Yii::$app->db->createCommand()->update('user', ['expo_token' => $data['token']], ['id' => $data['user_id']])->execute();
                }else{
                    array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Please provide token"));
                }
            } else {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "User Id is invalid"));
            }
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Please provide user"));
        }

        // If validation
        if (!empty($errors)) {
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, $errors, false);
        }

        return new ApiResponse($user, null, true);
    }
}