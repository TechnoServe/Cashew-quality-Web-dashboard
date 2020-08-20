<?php
namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use api\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\filters\AccessControl;

class UserController extends ActiveController
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
        return array_merge($behaviors,
            ['access' => [
                'class' => AccessControl::className(),
                'rules' => [

                    [
                        'actions' => ['index','save-user','change-password','update'],
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
            'save-user' => ['POST'],
            'change-password' => ['POST'],
            'update' => ['POST'],

           
        ],
    ],]);    }

        public $modelClass = 'common\models\User';


       public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

        public function actionChangepassword($id)
         {      
            $model = new User;

            $model = User::model()->findByAttributes(array('id'=>$id));
            $model->setScenario('changePwd');

            $errors = [];

             if(isset($_POST['User'])){
                    
                $model->attributes = $_POST['User'];
                $valid = $model->validate();
                        
                if($valid){
                        
                  $model->setPassword(new_password);
                        
                  if(!$model->save())
                    array_push($errors, new ApiError(ApiError::INVALID_DATA, "Password Could not be changed. Please try again"));
            
                    }
                }




        return new ApiResponse([], $null, true);


            //$this->render('changepassword',array('model'=>$model)); 
         }


}