<?php


namespace backend\models;


use common\models\FreeUsers;

class FreeUser extends FreeUsers
{
    public static function getUsersCountsByRoleAndTimePeriod($dates, $type){
        $data = [];
        foreach ($dates as $date){
            array_push($data, (int) self::find()
                //->where([">=", "DATE(created_at)" , date('Y-m-d', strtotime($date["startDate"]))])
                ->andWhere(["<=", "DATE(created_at)", date('Y-m-d', strtotime($date["endDate"]))])
                ->andWhere(["user_type" => $type])
                ->count());
        }
        return $data;
    }


    public static function countByPeriod($date){
        return self::find()
            ->where(["<=", "DATE(free_users.created_at)" , date('Y-m-d', strtotime($date))])
            ->count();
    }

}