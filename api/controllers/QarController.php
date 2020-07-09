<?php
namespace api\controllers;

use common\models\User;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;

class QarController extends ActiveController
{
    /*public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];
        return $behaviors;
    }*/
    public $modelClass = 'common\models\Qar';

}