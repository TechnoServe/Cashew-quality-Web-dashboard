<?php


namespace backend\models;


use common\helpers\CashewAppHelper;

class QarDetail extends \common\models\QarDetail
{


    public static function findQarDetailsAsArray($id_qar){
        return  self::find()->where(["id_qar"=>$id_qar])->select(['key','value','result','picture','sample_number', 'created_at', 'updated_at'])->asArray()->all();
    }

    public static function findOneMeasurementFromQarDetailsArray($measurement, $data){
        // find if measurement exists
        return CashewAppHelper::searchForValueInArray($measurement, $data);
    }
}