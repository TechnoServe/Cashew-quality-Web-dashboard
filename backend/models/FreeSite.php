<?php
namespace backend\models;

use common\models\FreeQarResult;
use common\models\FreeSites;

class FreeSite extends FreeSites
{
    public static function findBestSitesPerAverageQarByTimePeriod($startDate, $endDate){
        return self::find()
            ->leftJoin(FreeQar::tableName(), "free_sites.document_id = free_qar.site")
            ->leftJoin(FreeQarResult::tableName(), "free_qar.document_id = free_qar_result.qar")
            ->select(["free_sites.name", "free_sites.location", "AVG(free_qar_result.kor) as average_kor"])
            ->where([">=", "DATE(free_qar.created_at)" , date('Y-m-d', strtotime($startDate))])
            ->andWhere(["<=", "DATE(free_qar.created_at)", date('Y-m-d', strtotime($endDate))])
            ->groupBy(["free_sites.document_id"])
            ->orderBy(["average_kor" => SORT_DESC, "free_sites.created_at" => SORT_ASC])
            ->limit(10)->asArray()->all();
        }


    public static function findBestSitesPerNumberOfQarsByTimePeriod($startDate, $endDate){
        return self::find()
            ->leftJoin(FreeQar::tableName(), "free_sites.document_id = free_qar.site")
            ->leftJoin(FreeQarResult::tableName(), "free_qar.document_id = free_qar_result.qar")
            ->select(["free_sites.name", "free_sites.location", "COUNT(free_qar.document_id) as number_qar"])
            ->where([">=", "DATE(free_qar.created_at)" , date('Y-m-d', strtotime($startDate))])
            ->andWhere(["<=", "DATE(free_qar.created_at)", date('Y-m-d', strtotime($endDate))])
            ->andWhere(["free_qar.status" => 2])
            ->groupBy(["free_sites.document_id"])
            ->orderBy(["number_qar" => SORT_DESC, "free_sites.created_at" => SORT_ASC])
            ->limit(10)->asArray()->all();
    }
}