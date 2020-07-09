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
}