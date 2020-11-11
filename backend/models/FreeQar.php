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
            ->select(["free_qar.document_id", "free_qar_result.kor", "free_qar_result.location_lat", "free_qar_result.location_lon",  "free_qar_result.location_accuracy", "free_sites.name"])
            ->where([">=", "DATE(free_qar.created_at)" , date('Y-m-d', strtotime($startDate))])
            ->andWhere(["<=", "DATE(free_qar.created_at)", date('Y-m-d', strtotime($endDate))])
            ->asArray()->all();

        $rtn = [];


        $lat_array = array_filter(array_map(function ($item){
            return $item["location_lat"];
        }, $data));

        $lon_array = array_filter(array_map(function ($item){
            return $item["location_lon"];
        }, $data));

        if($lat_array && $lon_array) {

            //Center for all markers
            $rtn ["center"] = [min(array_filter($lat_array)), max(array_filter($lon_array))];

            $rtn ["markers"] = [];
            foreach ($data as $row) {
                array_push($rtn["markers"], [
                    "position" => [(double)$row["location_lat"], (double)$row["location_lon"]],
                    "title" => $row["name"],
                    "kor" => $row["kor"],
                    "lon" => $row["location_lon"],
                    "lat" => $row["location_lat"],
                    "acc" => $row["location_accuracy"]
                ]);
            }
        }

        return $rtn;
    }

    public static function getKorsAndLocations($startDate, $endDate)
    {
        $data = self::find()
            ->innerJoin("free_qar_result", "free_qar_result.qar = free_qar.document_id")
            ->leftJoin("free_sites", "free_sites.document_id = free_qar.site")
            ->select(["free_qar.document_id", "free_qar_result.kor", "free_qar_result.location_accuracy", "free_qar_result.location_lat", "free_qar_result.location_lon", "free_qar_result.location_country", "free_qar_result.location_country_code", "free_qar_result.location_city", "free_qar_result.location_region", "free_qar_result.location_sub_region", "free_qar_result.location_district", "free_qar_result.location_accuracy", "free_sites.name"])
            ->where([">=", "DATE(free_qar.created_at)" , date('Y-m-d', strtotime($startDate))])
            ->andWhere(["<=", "DATE(free_qar.created_at)", date('Y-m-d', strtotime($endDate))])
            ->asArray()->all();

        return $data;
    }

    public static function getKorsByRegion($startDate, $endDate, $region = null)
    {
        $data = self::find()->innerJoin("free_qar_result", "free_qar_result.qar = free_qar.document_id");
        
        if ($region)
            $data->where(["free_qar_result.location_region" => $region]);

        return $data->select(["free_qar.document_id", "free_qar_result.kor", "free_qar_result.location_accuracy", "free_qar_result.location_lat", "free_qar_result.location_lon", "free_qar_result.location_country", "free_qar_result.location_country_code", "free_qar_result.location_city", "free_qar_result.location_region", "free_qar_result.location_sub_region", "free_qar_result.location_district", "free_qar_result.location_accuracy", "free_sites.name"])
            ->where([">=", "DATE(free_qar.created_at)" , date('Y-m-d', strtotime($startDate))])
            ->andWhere(["<=", "DATE(free_qar.created_at)", date('Y-m-d', strtotime($endDate))])
            ->asArray()->all();
    }
    public static function getKorsBySite($startDate, $endDate, $site = null)
    {
        $data = self::find()->innerJoin("free_qar_result", "free_qar_result.qar = free_qar.document_id");
        
        if ($site)
            $data->where(["free_qar.site" => $site]);

        return $data->select(["free_qar.document_id", "free_qar_result.kor", "free_qar_result.location_accuracy", "free_qar_result.location_lat", "free_qar_result.location_lon", "free_qar_result.location_country", "free_qar_result.location_country_code", "free_qar_result.location_city", "free_qar_result.location_region", "free_qar_result.location_sub_region", "free_qar_result.location_district", "free_qar_result.location_accuracy", "free_sites.name"])
            ->where([">=", "DATE(free_qar.created_at)" , date('Y-m-d', strtotime($startDate))])
            ->andWhere(["<=", "DATE(free_qar.created_at)", date('Y-m-d', strtotime($endDate))])
            ->asArray()->all();
    }
}