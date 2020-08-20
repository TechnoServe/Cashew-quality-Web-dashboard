<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/10/17
 * Time: 3:43 PM
 */

namespace common\helpers;

use yii\helpers\Json;


class NotificationHelper
{
    public static function SendNotification($to, $title, $body,$type)
    {
        $ch = curl_init();
        $data[] = [
            "to" => $to,
            "data"=> [
                "type"=>$type,
            ],
            "title" => $title,
            "body" => $body,

        ];

        curl_setopt($ch, CURLOPT_URL, "https://exp.host/--/api/v2/push/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Json::encode($data));
        curl_setopt($ch, CURLOPT_POST, 1);

        var_dump($data);
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $res = 'Error:' . curl_error($ch);
            //var_dump($res);
            //die();
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        return true;
    }

}