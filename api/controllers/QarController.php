<?php

namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use backend\models\Qar;
use backend\models\Site;
use common\models\QarDetail;
use backend\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\validators\DateValidator;
use yii\filters\VerbFilter;

class QarController extends ActiveController
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
                        'actions' => ['index', 'view', 'export-csv', 'export-pdf', 'save', 'save-qar', 'save-detail', 'save-result'],
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
            'save-qar' => ['POST'],
            'save-detail' => ['POST'],
            'save-result' => ['POST'],
        ],
    ],]);
    }

    public $modelClass = 'common\models\Qar';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions ?????
        unset($actions['view']);
        unset($actions['index']);
        // customize the data provider preparation with the "prepareDataProvider()" method

        return $actions;
    }

    public function actionIndex()
    {
        // Initiate search query
        $query = Qar::find();

        // Search has to be performed on completed field work
        $query->andWhere(["status" => Qar::STATUS_COMPLETED])->all();

        // Get filter parameters from query params
        $filter =  Yii::$app->request->getQueryParams();

         // Filter by buyer if passed
        (isset($filter['buyer']) && $filter['buyer']) ? $query->andFilterWhere(['like', 'buyer', trim($filter['buyer'])]) : null;


        return new ApiResponse($query->all(), null, true);



    }


    public function actionView($id)
    {
        $qar = Qar::queryByCompany(Yii::$app->user->identity)->andWhere(["id" => $id])->one();

        if(!$qar) {
            Yii::$app->response->statusCode = 404;
            return new ApiResponse(null, [new ApiError(ApiError::INVALID_DATA, "Invalid QAR ID")], false);
        }

        $data = [
            Qar::FIELD_LOT_INFO => [
                Qar::FIELD_NUMBER_OF_BAGS_SAMPLED => $qar->number_of_bags,
                Qar::FIELD_TOTAL_NUMBER_OF_BAGS => $qar->number_of_bags,
                Qar::FIELD_VOLUME_TOTAL_STOCK => $qar->volume_of_stock
            ],
            Qar::FIELD_REQUEST_ID => $qar->id
        ];

        foreach ($qar->qarDetails as $detail) {
            $data[$detail->key] = [
                'value' => $detail->value,
                'picture' => $detail->picture,
                'value_with_shell' => $detail->value_with_shell,
                'value_without_shell' => $detail->value_without_shell,
            ];
        }

        return new ApiResponse($data, null, true);

    }

    public function actionSaveQar()
    {

        $data = Yii::$app->request->post();

        $qar = new Qar();

        $errors = [];
        if(!empty($data['buyer'])) {
            $buyerExists = User::queryByCompany()->andWhere([
                "role" => User::ROLE_FIELD_BUYER,
                "id" => $data['buyer']
            ])->exists();
            if ($buyerExists) {
                $qar->buyer = $data['buyer'];
            } else {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Buyer is invalid"));
            }
        }else{
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Buyer is empty"));
        }

        if(!empty($data['field_tech'])) {
        $field_techExist = User::queryByCompany()->andWhere(["role" => User::ROLE_FIELD_TECH, "id" => $data['field_tech']])->exists();
        if($field_techExist){
            $qar->field_tech = $data['field_tech'];
        }else{
            array_push($errors, new ApiError(ApiError::INVALID_DATA, "Field Tech is invalid"));
        }
        }else{
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Field Tech is empty"));
        }

        $initiator = Yii::$app->user->identity->role == User::ROLE_FIELD_TECH ? QAR::INITIATED_BY_FIELD_TECH : QAR::INITIATED_BY_BUYER;
        $qar->initiator = $initiator;


        if(!empty($data['site'])) {
        $site_exist = Site::queryByCompany()->andWhere(["id"=>$data['site']])->exists();
        if($site_exist){
            $qar->site = $data['site'];
        }else{
            array_push($errors, new ApiError(ApiError::INVALID_DATA, "Site is invalid"));
        }
        }else{
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Site is empty"));
        }



        //$dateValidator = new DateValidator();
        if(empty(trim($data['deadline'])))
            array_push($errors, new ApiError(ApiError::INVALID_DATA, "Please provide deadline"));
        else if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data['deadline']))
            array_push($errors, new ApiError(ApiError::INVALID_DATA, "Invalid date format"));
        else
            $qar->deadline = $data['deadline'];

        if(!empty($errors)){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, $errors, false);
        }

        $qar->company_id = Yii::$app->user->identity->company_id;

        if(!empty($data[Qar::FIELD_LOT_INFO][Qar::FIELD_TOTAL_NUMBER_OF_BAGS])) {
        $qar->number_of_bags = $data[Qar::FIELD_LOT_INFO][Qar::FIELD_TOTAL_NUMBER_OF_BAGS];
        }else{
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Number total bags is empty"));
        }

        if(!empty($data[Qar::FIELD_LOT_INFO][Qar::FIELD_VOLUME_TOTAL_STOCK])) {
        $qar->volume_of_stock = $data[Qar::FIELD_LOT_INFO][Qar::FIELD_VOLUME_TOTAL_STOCK];
        }else{
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Volume total stock is empty"));
        }
        $qar->save();

        return new ApiResponse($qar, null, true);
    }

    public function actionSaveDetail()
    {
        $data = Yii::$app->request->post();

        $errors = [];
        $data_keys = [
            Qar::FIELD_NUT_WEIGHT,
            Qar::FIELD_NUT_COUNT,
            Qar::FIELD_MOISTURE_CONTENT,
            Qar::FIELD_FOREIGN_MATERIAL,
            Qar::FIELD_GOOD_KERNEL,
            Qar::FIELD_SPOTTED_KERNEL,
            Qar::FIELD_IMMATURE_KERNEL,
            Qar::FIELD_OILY_KERNEL,
            Qar::FIELD_BAD_KERNEL,
            Qar::FIELD_VOID_KERNEL
        ];

        $qar = new Qar();

        foreach ($data as $key => $value) {
            if (in_array($key, $data_keys)) {
                $qar_detail = new QarDetail();
                $qar_detail->key = $key;
                $qar_detail->value = $value['value'];
                $qar_detail->value_with_shell = $value['value_with_shell'];
                $qar_detail->value_without_shell = $value['value_with_shell'];
                $qar_detail->picture = $value['picture'];
                if(!empty($data['id'])) {
                    $field_techExist = User::queryByCompany()->exists();
                    if($field_techExist) {
                        $qar_detail->id_qar = $data['id'];
                    }else{
                        array_push($errors, new ApiError(ApiError::INVALID_DATA, "Field Tech is invalid"));
                    }
                }else{
                    array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Id is empty"));
                }
                $qar_detail->result = 0;
                $qar_detail->save();
            }
        }
        if(!empty($errors)){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, $errors, false);
        }

        return new ApiResponse($qar, null, true);
    }

    public function actionSaveResult()
    {

        $data = Yii::$app->request->post();

        $errors = [];

        $result_keys = [
            Qar::RESULT_DEFECTIVE_RATE,
            Qar::RESULT_FOREIGN_MATERIAL_RATE,
            Qar::RESULT_KOR,
            Qar::RESULT_MOISTURE_CONTENT,
            Qar::RESULT_NUT_COUNT,
            Qar::RESULT_USEFUL_KERNEL
        ];

        $qar = new Qar();

        foreach ($data as $key => $value) {
              if (in_array($key, $result_keys)) {
                  $qar_detail = new QarDetail();
                  $qar_detail->key = $key;
                  $qar_detail->value = $value['value'];
                  $qar_detail->value_with_shell = $value['value_with_shell'];
                  $qar_detail->value_without_shell = $value['value_with_shell'];
                  $qar_detail->picture = $value['picture'];
                  if(!empty($data['id'])) {
                      $field_techExist = User::queryByCompany()->exists();
                      if($field_techExist) {
                            $qar_detail->id_qar = $data['id'];
                      }else{
                          array_push($errors, new ApiError(ApiError::INVALID_DATA, "Field Tech is invalid"));
                      }
                  }else{
                      array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Id is empty"));
                  }
                  $qar_detail->result = 1;
                  $qar_detail->save();
              }
        }
        if(!empty($errors)){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, $errors, false);
        }

        return new ApiResponse($qar, null, true);
    }

}