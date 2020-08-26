<?php
namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use api\models\User;
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
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                $user = User::findByUsername($username);
                if ($user && $user->validatePassword($password)) {
                    return $user;
                }
            }
        ];
        return array_merge($behaviors,
            ['access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'actions' => ['index','save-user','change-password','update','password-reset'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'allow' => true,
                        'roles' => [User::ROLE_INSTITUTION_ADMIN, User::ROLE_FIELD_TECH, User::ROLE_FIELD_FARMER, User::ROLE_FIELD_BUYER],
                    ],

                ],
            ],

            'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
            'password-reset' => ['POST'],
            'change-password' => ['POST'],

           
           ],
       ],
   ]);    

 }

        public $modelClass = 'api\models\User';


        public function actionChangePassword()

         {   

            $user = User::find()->one();

            $model = new ChangePassword();

            $errors = [];

             if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
             
                    array_push($errors, new ApiError(ApiError::INVALID_DATA, "Password changed"));

               }else{

                    array_push($errors, new ApiError(ApiError::INVALID_DATA, "Password Could not be changed. Please try again"));

               }

              return new ApiResponse([], null, true);
        }


        public function actionPasswordReset()

       {
        
      $data = Yii::$app->request->post();

      $model = new PasswordResetRequestForm();

      $model->email = $data["email"];

        if ($model->validate()) {

            if ($model->sendEmail()) {
        
        array_push($errors, new ApiError(ApiError::INVALID_DATA, "Password Reset E-mail Sent"));
        } else {

        array_push($errors, new ApiError(ApiError::INVALID_DATA, "Password Could not be changed. Please try again"));

      }
    
    return new ApiResponse([], null, true);

     }

   }


}