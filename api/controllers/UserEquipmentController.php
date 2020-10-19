<?php
namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use api\models\User as ModelsUser;
use backend\models\UserEquipment;
use backend\models\User;
use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

class UserEquipmentController extends ActiveController
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

    public $modelClass = 'common\models\UserEquipment';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions ?????
        // customize the data provider preparation with the "prepareDataProvider()" method

        return $actions;
    }

    public function actionSaveEquipment() 
    {
        $data = Yii::$app->request->post();

        $equipment = new UserEquipment();

        $equipment->id_user = Yii::$app->user->getId();

        $errors = [];

        if (isset($data['brand']) && !empty($data['brand'])) {
            $equipment->brand = $data['brand'];
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Brand is required"));
        }

        if (isset($data['model']) && !empty($data['model'])) {
            $equipment->model = $data['model'];
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Model is required"));
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $equipment->name = $data['name'];
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Name is required"));
        }

        if (!isset($data['manufacturing_date']) || empty(trim($data['manufacturing_date']))) {
            array_push($errors, new ApiError(ApiError::INVALID_DATA, "Please provide manufacturing date"));
        } else {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $data['manufacturing_date'])) {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Invalid date format"));           
            } else {
                $equipment->manufacturing_date = $data['manufacturing_date'];        
            }
        }

        if(isset($data['image']) && !empty($data['image'])){
            if(!isset($data['image']['filename']) || empty($data['image']['filename']) || !preg_match("([^\\s]+(\\.(?i)(gif|jpg|png))$)", $data['image']['filename'])){
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Please provide valid filename"));
            }

            if(!isset($data['image']['content']) || empty($data['image']['content'])){
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Please provide valid file content"));
            }
        }else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Equipment image should be sent"));
        }

        if (!empty($errors)) {
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, $errors, false);
        }

        $fileRandomBaseName = uniqid('equipment_').'_'.date('Y_m_d-H_i_s', time()). "." . explode(".", $data["image"]["filename"])[1];
        $filename = Yii::getAlias("@backend") . "/web/uploads/equipments/" . $fileRandomBaseName;

        $this->base64_to_jpeg($data['image']['content'], $filename);

        $equipment->picture = $fileRandomBaseName;

        if(!$equipment->save(false)){
             return $equipment->getErrors();
        }

        $equipment = $equipment->toArray();
        $equipment["id_user"] = ModelsUser::findOne($equipment["id_user"]);

        return new ApiResponse($equipment, null, true);
    }

    function base64_to_jpeg($base64, $filename)
    {
        $ifp = fopen($filename, 'wb');
        $data = explode(',', $base64);
        fwrite($ifp, base64_decode($data[1]));
        fclose($ifp);
        return $filename;
    }
    
}