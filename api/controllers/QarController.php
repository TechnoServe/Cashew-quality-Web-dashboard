<?php

namespace api\controllers;

use backend\models\Qar;
use common\models\QarDetail;
use backend\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

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
        return $behaviors;
    }

    public $modelClass = 'common\models\Qar';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions ?????
        unset($actions['view']);
        // customize the data provider preparation with the "prepareDataProvider()" method

        return $actions;
    }

    public function actionView($id)
    {
        $qar = Qar::findOne($id);
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
        return $data;

    }

    public function actionSave()
    {

        $data = Yii::$app->request->post();

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
        $result_keys = [
            Qar::RESULT_DEFECTIVE_RATE,
            Qar::RESULT_FOREIGN_MATERIAL_RATE,
            Qar::RESULT_KOR,
            Qar::RESULT_MOISTURE_CONTENT,
            Qar::RESULT_NUT_COUNT,
            Qar::RESULT_USEFUL_KERNEL
        ];

        $qar = new Qar();

        $qar->buyer = $data['buyer'];
        $qar->field_tech = $data['field_tech'];
        $qar->site = $data['site'];
        $qar->initiator = $data['initiator'];
        $qar->number_of_bags = $data[Qar::FIELD_LOT_INFO][Qar::FIELD_TOTAL_NUMBER_OF_BAGS];
        $qar->volume_of_stock = $data[Qar::FIELD_LOT_INFO][Qar::FIELD_VOLUME_TOTAL_STOCK];
        $qar->save();
        $qar->refresh();

        foreach ($data as $key => $value) {
            if (in_array($key, $data_keys)) {
                $qar_detail = new QarDetail();
                $qar_detail->key = $key;
                $qar_detail->value = $value['value'];
                $qar_detail->value_with_shell = $value['value_with_shell'];
                $qar_detail->value_without_shell = $value['value_with_shell'];
                $qar_detail->picture = $value['picture'];
                $qar_detail->id_qar = $qar->id;
                $qar_detail->result = 0;
                $qar_detail->save();
            } elseif (in_array($key, $result_keys)) {
                $qar_detail = new QarDetail();
                $qar_detail->key = $key;
                $qar_detail->value = $value['value'];
                $qar_detail->value_with_shell = $value['value_with_shell'];
                $qar_detail->value_without_shell = $value['value_with_shell'];
                $qar_detail->picture = $value['picture'];
                $qar_detail->id_qar = $qar->id;
                $qar_detail->result = 1;
                $qar_detail->save();
            }
        }
        return $qar;
    }

    public function actionSaveQar()
    {

        $data = Yii::$app->request->post();

        $qar = new Qar();

        $buyerExists = User::queryByCompany()->andWhere([User::ROLE_FIELD_BUYER => $data['buyer']])->exists();
        if($buyerExists){
            $qar->buyer = $data['buyer'];
        }else{
            $qar = 'This buyer does not exist';
        }

        $field_techExist = User::queryByCompany()->andWhere([User::ROLE_FIELD_TECH => $data['field_tech']])->exists();
        if($field_techExist){
            $qar->field_tech = $data['field_tech'];
        }else{
            $qar = 'This field tech does not exist';
        }
        $qar->site = $data['site'];
        $qar->initiator = $data['initiator'];
        $qar->number_of_bags = $data[Qar::FIELD_LOT_INFO][Qar::FIELD_TOTAL_NUMBER_OF_BAGS];
        $qar->volume_of_stock = $data[Qar::FIELD_LOT_INFO][Qar::FIELD_VOLUME_TOTAL_STOCK];
        $qar->save();
        $qar->refresh();

        return $qar;
    }


}