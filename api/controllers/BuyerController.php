<?php

namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use api\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;


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
        return array_merge(
            $behaviors,
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'index' => ['GET'],
                        'view' => ['GET']
                    ],
                ],
            ]);
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


    /**
     * Method can be passed parameters which will be used to filter result
     * Responds to request to get list of buyers
     * @return array
     */
    public function actionIndex() {

        // Initiate search query
        $query = $this->modelClass::queryByCompany();

        // Search has to be performed on active buyers
        $query->andWhere(["role" => User::ROLE_FIELD_BUYER]) ->andWhere(["status" => User::STATUS_ACTIVE]);

        // Get filter parameters from query params
        $filter =  Yii::$app->request->getQueryParams();

        // Filter by username if passed
        (isset($filter['username']) && $filter['username']) ? $query->andFilterWhere(['like', 'username', trim($filter['username'])]) : null;

        // Filter by name if passed
        (isset($filter['name']) && $filter['name']) ? $query->andFilterWhere(['or',
                ['like', 'first_name', trim($filter['name'])],
                ['like', 'middle_name', trim($filter['name'])],
                ['like', 'last_name', trim($filter['name'])],
            ]
        ) : null;

        // Filter by email if passed
        (isset($filter['email']) && $filter['email']) ? $query->andFilterWhere(['like', 'email', trim($filter['email'])]) : null;

        // Filter by phone if passed
        (isset($filter['phone']) && $filter['phone'])? $query->andFilterWhere(['like', 'phone', trim($filter['phone'])]) : null;

        return new ApiResponse($query->all(), null, true);
    }


    /**
     * Handles request to get details of a specific buyer by id
     * @param $id
     * @return ApiResponse
     */
    public function actionView($id)
    {
        $field_tech = $this->modelClass::queryByCompany()->andWhere(['id' => $id, 'role' => $this->modelClass::ROLE_FIELD_BUYER])->one();

        if ($field_tech) {
            return new ApiResponse($field_tech, null, true);
        } else {
            Yii::$app->response->statusCode = 404;
            return new ApiResponse(null, [new ApiError(ApiError::INVALID_DATA, "Invalid Buyer ID")], false);
        }
    }
}
