<?php


namespace common\helpers;


use DateTime;
use kartik\mpdf\Pdf;
use function GuzzleHttp\Psr7\str;

class CashewAppHelper
{

    /**
     * @param null $startDate
     * @param null $endDate
     * @param null $predefinedPeriod
     * @return array|mixed
     */
    public static function calculateStartDateAndEndDateForAnalytics($startDate = null, $endDate = null, $predefinedPeriod=null){

        if(!$startDate   && $predefinedPeriod == 1)
            return self::calculateThisWeekDatePeriod();

        if(!$startDate   && $predefinedPeriod == 2)
            return self::calculateThisMonthDatePeriod();

        if(!$startDate && $predefinedPeriod == 3)
            return self::calculateThisQuarterDatePeriod();

        if(!$startDate && $predefinedPeriod == 4)
            return self::calculateThisYearDatePeriod();

        if($startDate && !$endDate)
            return [$startDate, date("Y-m-d", strtotime("now"))];

        if($startDate && $endDate)
            return  [$startDate, $endDate];

        // Weekly is default
        return self::calculateThisWeekDatePeriod();
    }


    /**
     * @return mixed
     */
    public static function calculateThisWeekDatePeriod(){
        $dto = new DateTime();
        $dto->setISODate(date("Y", strtotime('now')), date("W", strtotime('now')));
        $ret[0] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret[1] = $dto->format('Y-m-d');
        return $ret;

    }

    /**
     * @return array
     */
    public static function calculateThisMonthDatePeriod(){
        $currentMonth = date ("m", strtotime("now"));
        $currentYear = date ("Y", strtotime("now"));
        return [
            date("Y-m-d", strtotime($currentYear . "-" .$currentMonth . "-01")),
            date("Y-m-t", strtotime($currentYear . "-" .$currentMonth . "-01"))
        ];
    }

    /**
     * @return array
     */
    public static function calculateThisQuarterDatePeriod(){
        $currentMonth = date ("m", strtotime("now"));
        $currentYear = date ("Y", strtotime("now"));
        $yearQuarter = ceil($currentMonth / 3);

        $firstMonthOfTheQuarter = ($yearQuarter * 3 - 3) + 1;

        return  [
            date("Y-m-d", strtotime($currentYear . "-". $firstMonthOfTheQuarter ."-01")),
            date("Y-m-t", strtotime($currentYear . "-" .($firstMonthOfTheQuarter+2). "-01"))
        ];
    }

    /**
     * @return array
     */
    public static function calculateThisYearDatePeriod(){
        $currentYear = date ("Y", strtotime("now"));
        return [
            date("Y-m-d", strtotime($currentYear . "-01-01")),
            date("Y-m-t", strtotime($currentYear . "-12-01"))
        ];
    }

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


    /**
     * Used to render pdf and send as downloadable in browser
     * @param $content
     * @param string $format
     * @param string $orientation
     * @param null $css
     * @param null $marginOptions
     * @param null $filename
     *
     * @return mixed
     */
    public static function renderPDF($content, $format = Pdf::FORMAT_A4, $orientation = Pdf::ORIENT_LANDSCAPE, $css = null, $marginOptions = null, $filename = null) {
        error_reporting(0);
        $options = [
            'mode' => Pdf::MODE_UTF8,
            'filename' => $filename,
            'format' => $format,
            'orientation' => $orientation,
            'destination' => Pdf::DEST_DOWNLOAD,
            'content' => $content,
            'cssFile' => '@backend/web/css/pdf.css',
            'cssInline' => $css,
            'methods' => [
                'SetFooter' => ['{PAGENO}'],
            ],
            'options' => [
                'autoLangToFont' => true,
                'autoScriptToLang' => true,
            ],
        ];

        if (is_array($marginOptions)) {
            $options = array_merge($options, $marginOptions);
        }

        $pdf = new Pdf($options);

        return $pdf->render();
    }
}