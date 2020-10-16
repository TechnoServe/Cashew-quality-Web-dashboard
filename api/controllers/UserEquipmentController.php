<?php
namespace api\controllers;

use api\components\ApiError;
use api\components\ApiResponse;
use api\models\User as ModelsUser;
use backend\models\UserEquipment;
use backend\models\User;
use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
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

        $errors = [];
        if (isset($data['id_user']) && !empty($data['id_user'])) {
            $userExists = User::queryByCompany()->andWhere([
                "role" => User::ROLE_FIELD_TECH,
                "id" => $data['id_user']
            ])->exists();
            if ($userExists) {
                $equipment->id_user = $data['id_user'];
            } else {
                array_push($errors, new ApiError(ApiError::INVALID_DATA, "Field Tech is invalid"));
            }
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Field Tech is empty"));
        }

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


        

        $filename = Yii::getAlias("@backend") . "/web/uploads/equipments/" . $data['image']['filename'];
        $equipment->image = $this->base64_to_jpeg($data['image']['content'], $filename);

        if (isset($data['image']) && !empty($data['image'])) {
            $equipment->image = $data['image'];
        } else {
            array_push($errors, new ApiError(ApiError::EMPTY_DATA, "Image is required"));
        }

        if (!empty($errors)) {
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, $errors, false);
        }

        // if(!$equipment->save()){
        //     return $equipment->getErrors();
        // }

        $equipment->save();

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