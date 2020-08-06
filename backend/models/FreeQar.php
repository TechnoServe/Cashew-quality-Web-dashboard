<?php


namespace backend\models;


use common\models\FreeQarResult;
use common\models\FreeSites;

class FreeQar extends \common\models\FreeQar
{

    public static function getQarCountsByStatusAndTimePeriod($dates, $status){
     $data = [];
     foreach ($dates as $date){
         array_push($data, (int) self::find()
             ->where([">=", "DATE(created_at)" , date('Y-m-d', strtotime($date["startDate"]))])
             ->andWhere(["<=", "DATE(created_at)", date('Y-m-d', strtotime($date["endDate"]))])
             ->andWhere(["status" => $status])
             ->count());
     }
     return $data;
    }

    public static function getAverageKorOfQarByTimePeriod($dates){
        $data = [];
        foreach ($dates as $date){
            array_push($data, (float) self::find()->innerJoin(FreeQarResult::tableName(), "free_qar.document_id = free_qar_result.qar")
                ->where([">=", "DATE(free_qar.created_at)" , date('Y-m-d', strtotime($date["startDate"]))])
                ->andWhere(["<=", "DATE(free_qar.created_at)", date('Y-m-d', strtotime($date["endDate"]))])
                ->andWhere(["free_qar.status"=> 2])
                ->average('free_qar_result.kor'));
        }
        return $data;
    }
}