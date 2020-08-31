<?php

namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use backend\models\Qar;
use backend\models\Site;
use backend\models\Company;
use common\models\QarDetail;
use backend\models\User;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\validators\DateValidator;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use common\helpers\QarNotificationHelper;


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
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [

                        [
                            'actions' => [
                                'index',
                                'view',
                                'export-csv',
                                'export-pdf',
                                'save',
                                'save-qar',
                                'save-detail',
                                'save-result',
                                'notification'
                            ],
                            'allow' => true,
                            'roles' => ['@'],
                        ],

                        [
                            'allow' => true,
                            'roles' => [
                                User::ROLE_INSTITUTION_ADMIN,
                                User::ROLE_FIELD_TECH,
                                User::ROLE_FIELD_FARMER,
                                User::ROLE_FIELD_BUYER
                            ],
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
                ],
            ]);
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
        $buyers=[];
        $field_techs=[];

        // Get filter parameters from query params
        $filter =  Yii::$app->request->getQueryParams();

        if(isset($filter['buyer']) && !empty($filter['buyer']))
        {
           $buyers = ArrayHelper::getColumn(User::queryByCompany()->andWhere(['or',
                ['like', 'first_name', trim($filter['buyer'])],
                ['like', 'username', trim($filter['buyer'])],
                ['like', 'middle_name', trim($filter['buyer'])],
                ['like', 'last_name', trim($filter['buyer'])],
            ])->andWhere(["role" => User::ROLE_FIELD_BUYER])->all(),'id');
        }

        if(isset($filter['field_tech']) && !empty($filter['field_tech']))
        {
           $field_techs = ArrayHelper::getColumn(User::queryByCompany()->andWhere(['or',
                ['like', 'first_name', trim($filter['field_tech'])],
                ['like', 'username', trim($filter['field_tech'])],
                ['like', 'middle_name', trim($filter['field_tech'])],
                ['like', 'last_name', trim($filter['field_tech'])],
            ])->andWhere(["role" => User::ROLE_FIELD_TECH])->all(),'id');
        }

        // Initiate search query
        $query = Qar::queryByCompany()->leftJoin(Site::tableName(), 'qar.site = site.id')
            ->select(['qar.id','qar.buyer', 'qar.field_tech','qar.farmer','qar.id','site.site_name','qar.number_of_bags', 'qar.volume_of_stock', 'qar.deadline','qar.created_at'])
            ->andFilterWhere(['in', 'qar.buyer',$buyers])
            ->andFilterWhere(['in', 'qar.field_tech',$field_techs]);

            if(isset($filter['site_name']))
                $query->andFilterWhere(['like', 'site.site_name' , $filter['site_name']]);


        return new ApiResponse($query->asArray()->all(), null, true);

    }


    public function actionView($id)
    {
        $qar = Qar::queryByCompany(Yii::$app->user->identity)->andWhere(["id" => $id])->one();

        if (!$qar) {
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
        if (isset($data['buyer']) && !empty($data['buyer'])) {
            $buyerExists = User::queryByCompany()->andWhere([
                "role" => User::ROLE_FIELD_BUYER,
                "id" => $data['buyer']
            ])->exists();
            if ($buyerExists) {
                $qar->buyer = $data['buyer'];
            } else {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Buyer is invalid"));
            }
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Please provide buyer"));
        }

        if (isset($data['field_tech']) && !empty($data['field_tech'])) {
            $field_techExist = User::queryByCompany()->andWhere([
                "role" => User::ROLE_FIELD_TECH,
                "id" => $data['field_tech']
            ])->exists();
            if ($field_techExist) {
                $qar->field_tech = $data['field_tech'];
            } else {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Field Tech is invalid"));
            }
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Field Tech is empty"));
        }

        $initiator = Yii::$app->user->identity->role == User::ROLE_FIELD_TECH ? QAR::INITIATED_BY_FIELD_TECH : QAR::INITIATED_BY_BUYER;
        $qar->initiator = $initiator;


        if (isset($data['site']) && !empty($data['site'])) {
            $site_exist = Site::queryByCompany()->andWhere(["id" => $data['site']])->exists();
            if ($site_exist) {
                $qar->site = $data['site'];
            } else {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Site is invalid"));
            }
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Site is empty"));
        }


        //$dateValidator = new DateValidator();
        if (!isset($data['deadline']) || empty(trim($data['deadline']))) {
            array_push($errors, new ApiError(ApiError::INVALID_DATA, "Please provide deadline"));
        } else {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $data['deadline'])) {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Invalid date format"));
            } else {
                $qar->deadline = $data['deadline'];
            }
        }


        $qar->company_id = Yii::$app->user->identity->company_id;

        if (!isset($data[Qar::FIELD_LOT_INFO][Qar::FIELD_TOTAL_NUMBER_OF_BAGS]) && empty($data[Qar::FIELD_LOT_INFO][Qar::FIELD_TOTAL_NUMBER_OF_BAGS])) {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Number total bags is required"));
        } else {
            if (!is_numeric($data[Qar::FIELD_LOT_INFO][Qar::FIELD_TOTAL_NUMBER_OF_BAGS])) {
                array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Number total bags is not a number"));
            } else {

                $qar->number_of_bags = $data[Qar::FIELD_LOT_INFO][Qar::FIELD_TOTAL_NUMBER_OF_BAGS];
            }
        }

        if (!isset($data[Qar::FIELD_LOT_INFO][Qar::FIELD_VOLUME_TOTAL_STOCK]) && empty($data[Qar::FIELD_LOT_INFO][Qar::FIELD_VOLUME_TOTAL_STOCK])) {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Volume total stock is required"));
        } else {
            if (!is_numeric($data[Qar::FIELD_LOT_INFO][Qar::FIELD_VOLUME_TOTAL_STOCK])) {
                array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Volume total stock is not a number"));
            } else {
                $qar->volume_of_stock = $data[Qar::FIELD_LOT_INFO][Qar::FIELD_VOLUME_TOTAL_STOCK];
            }
        }

        // If validation
        if (!empty($errors)) {
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, $errors, false);
        }

        if($qar->save()){
            (new QarNotificationHelper())->constructAPIQarCreateNotification($qar);
        }

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


        $id_qar = 0;


        if (isset($data['id']) && !empty($data['id'])) {
            $qar_exist = QAR::queryByCompany()->andWhere(["id"=>$data["id"]])->exists();
            if ($qar_exist) {
                $id_qar = (int)$data['id'];
            } else {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "QAR is invalid"));
            }
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "QAR is not provided"));
        }


        $transaction = Yii::$app->db->beginTransaction();

        if ($qar_exist) {


            foreach ($data['data'] as $datum) {

                foreach ($datum as $key => $value) {
                    if (in_array($key, $data_keys)) {
                        $qar_detail = new QarDetail();
                        $qar_detail->key = $key;


                        if ($this->isObjectVariableSetAndNotNull($value, 'value')) {
                            if (!is_numeric($value['value'])) {
                                array_push($errors, new ApiError(ApiError::INVALID_DATA, $key . " is not valid"));
                            } else {
                                $qar_detail->value = (float)$value['value'];
                            }
                        }


                        if ($this->isObjectVariableSetAndNotNull($value, 'value_with_shell')) {
                            if (!is_numeric($value['value_with_shell'])) {
                                array_push($errors, new ApiError(ApiError::INVALID_DATA, $key . " is not valid"));
                            } else {
                                $qar_detail->value_with_shell = (float)$value['value_with_shell'];
                            }
                        }

                        if ($this->isObjectVariableSetAndNotNull($value, 'value_without_shell')) {
                            if (!is_numeric($value['value_without_shell'])) {
                                array_push($errors, new ApiError(ApiError::INVALID_DATA, $key . " is not valid"));
                            } else {
                                $qar_detail->value_without_shell = (float)$value['value_without_shell'];
                            }
                        }

                    $qar_detail->picture = $value['image_url'];
                        if (!is_numeric($datum['sample_number'])) {
                            array_push($errors, new ApiError(ApiError::INVALID_DATA,  "Sample number is not valid"));
                        }else {
                            $qar_detail->sample_number = isset($datum['sample_number']) && !empty($datum['sample_number']) && $datum['sample_number'] > 0 ? $datum['sample_number'] : 1;
                        }
                    $qar_detail->id_qar = $id_qar;
                    $qar_detail->result = 0;

                        if (!$qar_detail->save()) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
            }
        }


        if (!empty($errors)) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, $errors, false);
        }

        $transaction->commit();



        Yii::$app->db->createCommand()->update('qar', ['status' => Qar::STATUS_IN_PROGRESS], ['id' => $id_qar])->execute();

        (new QarNotificationHelper())->constructAPIQarCreateDetailNotification($qar_detail);

        return new ApiResponse([], null, true);

    }

    public function actionSaveResult()
    {

        $data = Yii::$app->request->post();

        $errors = [];

        $id_qar = 0;

        if (isset($data['id']) && !empty($data['id'])) {
            $qar_exist = QAR::queryByCompany()->andWhere(["id" => $data["id"]])->exists();
            if ($qar_exist) {
                $id_qar = (int)$data['id'];
            } else {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Qar is invalid"));
            }
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Qar is not provided"));
        }

        $result_keys = [
            Qar::RESULT_DEFECTIVE_RATE,
            Qar::RESULT_FOREIGN_MATERIAL_RATE,
            Qar::RESULT_KOR,
            Qar::RESULT_MOISTURE_CONTENT,
            Qar::RESULT_NUT_COUNT,
            Qar::RESULT_USEFUL_KERNEL
        ];

        //$qar = new Qar();

        $transaction = Yii::$app->db->beginTransaction();

        if ($qar_exist) {

            foreach ($data['data'] as $datum) {

        if (!$this->isObjectVariableSetAndNotNull($datum,
                Qar::RESULT_DEFECTIVE_RATE) || !$this->isObjectVariableSetAndNotNull($datum,
                Qar::RESULT_FOREIGN_MATERIAL_RATE) || !$this->isObjectVariableSetAndNotNull($datum,
                Qar::RESULT_KOR) || !$this->isObjectVariableSetAndNotNull($datum,
                Qar::RESULT_MOISTURE_CONTENT) || !$this->isObjectVariableSetAndNotNull($datum,
                Qar::RESULT_NUT_COUNT) || !$this->isObjectVariableSetAndNotNull($datum,
                Qar::RESULT_USEFUL_KERNEL)) {
            // add error
            // return and halt execution
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Missing required parameters"));
        }

                foreach ($datum as $key => $value) {
                    if (in_array($key, $result_keys)) {
                        $qar_result = new QarDetail();
                        $qar_result->key = $key;

                        if (!is_numeric($value)) {
                            array_push($errors, new ApiError(ApiError::INVALID_DATA, $key . " is not valid"));
                        } else {
                            $qar_result->value = (float)$value;
                        }

                        if (!is_numeric($datum['sample_number'])) {
                            array_push($errors, new ApiError(ApiError::INVALID_DATA,  "Sample number is not valid"));
                        }else {
                            $qar_result->sample_number = isset($datum['sample_number']) && !empty($datum['sample_number']) && $datum['sample_number'] > 0 ? $datum['sample_number'] : 1;
                        }
                        $qar_result->id_qar = $id_qar;
                        $qar_result->result = 1;

                        if (!$qar_result->save()) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
            }
        }
            if (!empty($errors)) {
                $transaction->rollBack();
                Yii::$app->response->statusCode = 400;
                return new ApiResponse(null, $errors, false);
            }

            $transaction->commit();

        Yii::$app->db->createCommand()->update('qar', ['status' => Qar::STATUS_COMPLETED], ['id' => $id_qar])->execute();

        (new QarNotificationHelper())->constructAPIQarCreateResultNotification($qar_result);

            return new ApiResponse([], null, true);

    }

    private function isObjectVariableSetAndNotNull($array, $key)
    {
        return isset($array[$key]) && !empty($array[$key]);
    }

    public function actionNotification(){

        if(Yii::$app->queue->push(new QarNotification([
            'title' => 'This is the title',
            'body' => 'This is the body',
        ]))){
            return "Everything is ok";
        }else{
            return "Something went wrong";
        }
    }

}