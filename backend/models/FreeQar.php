<?php


namespace backend\models;


use common\models\FreeQarResult;
use common\models\FreeSites;
use yii\web\JsExpression;

class FreeQar extends \common\models\FreeQar
{

    public static function getQarCountsByStatusAndTimePeriod($dates, $status, $siteId = null){
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

    public static function getAverageKorOfQarByTimePeriod($dates, $siteId = null){
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

    public static function countByPeriod($startDate, $endDate){
        return self::find()
            ->where([">=", "DATE(created_at)" , date('Y-m-d', strtotime($startDate))])
            ->andWhere(["<=", "DATE(created_at)", date('Y-m-d', strtotime($endDate))])
            ->count();
    }


    public static function getKorsAndSiteLocations($startDate, $endDate){
        $data =  self::find()
            ->innerJoin("free_qar_result", "free_qar_result.qar = free_qar.document_id")
            ->leftJoin("free_sites", "free_sites.document_id = free_qar.site")
            ->select(["free_qar.document_id", "free_qar_result.kor", "free_qar_result.location_lat", "free_qar_result.location_lon", "free_sites.name"])
            ->where([">=", "DATE(free_qar.created_at)" , date('Y-m-d', strtotime($startDate))])
            ->andWhere(["<=", "DATE(free_qar.created_at)", date('Y-m-d', strtotime($endDate))])
            ->asArray()->all();

        $rtn = [];
        foreach ($data as $row){
            array_push($rtn, [
                "position" => [(double)$row["location_lat"], (double)$row["location_lon"]],
                "title" => $row["name"],
                "draggable" => true,
                "raiseOnDrag"=>true,
                "labelContent"=>"lable",
                "labelAnchor"=>new JsExpression("new google.maps.Point(3, 30)"),
                "labelClass"=>"labels",
                "labelInBackground"=>false
            ]);
        }
        return $rtn;
    }
}