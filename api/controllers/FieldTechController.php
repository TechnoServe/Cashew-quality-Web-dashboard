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
use yii\web\Response;


class FieldTechController extends ActiveController
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

    public $modelClass = 'api\models\User';
    // Some reserved attributes like maybe 'q' for searching all fields at once 
    // or 'sort' which is already supported by Yii RESTful API
   // public $reservedParams = ['sort','q'];

    public function actions()
    {
        $actions = parent::actions();
      //  $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
       unset($actions['index']);
       unset($actions['view']);
        return $actions;
    }

    public function actionIndex() {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        
        $field_techs
         = $this->modelClass::find()->where(['role' => $this->modelClass::ROLE_FIELD_TECH])->all();

        $data = [];
        foreach ($field_techs
         as $field_tech) {
            $data[] = $field_tech;
        }
        if ($field_techs
        ) {
            return $response->data = [
                        'data' => $data,
                        'code' => 200
                    ];
        } else {
            return $response->data = [
                        'data' => 'Not Found',
                        'code' => 404
                    ];
        }
        
    }

    public function actionView($id) {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        
            $field_tech = $this->modelClass::findOne(['id' => $id, 'role' => $this->modelClass::ROLE_FIELD_TECH]);

            if($field_tech){
                return $response->data = [
                        'data' => $field_tech,
                        'code' => 200
                    ];
            }else{
                return $response->data = [
                        'data' => 'Not Found',
                        'code' => 404
                    ];
            
            }
        }

}
