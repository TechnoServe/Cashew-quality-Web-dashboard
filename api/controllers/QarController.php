<?php
namespace api\controllers;

use api\models\Qar;
use common\models\QarDetail;
use common\models\User;
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
                Qar::FIELD_NUMBER_BAG_SAMPLED => $qar->number_of_bags,
                Qar::FIELD_NUMBER_TOTAL_BAGS => $qar->number_of_bags,
                Qar::FIELD_VOLUME_TOTAL_STOCK => $qar->volume_of_stock
            ],
            Qar::FIELD_REQUEST_ID=> $qar->id
        ];

        foreach ($qar->qarDetails as $detail) {
            $data[$detail->key] = [
                'value' => $detail->value,
                'picture' => $detail->picture,
                'value_with_shell'=>$detail->value_with_shell,
                'value_without_shell'=>$detail->value_without_shell,
            ];
        }
        return $data;

    }

    public function actionSave(){

        $data=Yii::$app->request->post();

        $qar=new Qar();

        foreach($data as $key => $value){
            switch ($key) {

                case 'buyer':
                    $qar->buyer=$value;
                    break;
                case 'field_tech':
                    $qar->field_tech=$value;
                    break;
                case 'site':
                    $qar->site=$value;
                    break;
                case 'initiator':
                    $qar->initiator=$value;
                    break;
                case Qar::FIELD_LOT_INFO:
                    $qar->number_of_bags=$value[Qar::FIELD_NUMBER_TOTAL_BAGS];
                    $qar->volume_of_stock=$value[Qar::FIELD_VOLUME_TOTAL_STOCK];
                    $qar->save();
                    $qar->refresh();
                    break;
                default:
                    $qar_detail=new QarDetail();
                    $qar_detail->key= $key;
                    $qar_detail->value=$value['value']??NULL;
                    $qar_detail->value_with_shell=$value['value_with_shell'];
                    $qar_detail->value_without_shell=$value['value_with_shell'];
                    $qar_detail->picture=$value['picture']??NULL;
                    $qar_detail->id_qar=$qar->id;
                    $qar_detail->save();
                    var_dump($qar->id);
                    die();
            }
        }

        return $qar;

    }


}