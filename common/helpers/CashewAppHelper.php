<?php


namespace common\helpers;


class CashewAppHelper
{
    public static function createFolderIfNotExist($path)
    {
        if ( ! file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }


    public static function groupAssArrayBy($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }


   public static function searchForValueInArray($key, $array) {
        foreach ($array as $measurement) {
            if ($measurement["key"] == $key) {
                return $measurement;
            }
        }
        return null;
    }
}