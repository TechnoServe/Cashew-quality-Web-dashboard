<?php


namespace backend\helpers;

use backend\models\Department;
use backend\models\Qar;
use backend\models\User;
use yii\helpers\Json;
use yii\web\JsExpression;
use Yii;
use function foo\func;

class SiteHelper
{

    public static function getQarChart($period, $siteId = null)
    {

        $series  = [];

        // QARs To-Be Done
        array_push(
            $series,
            [
                //'type' => 'column',
                'name' => Yii::t("app", "To Be Done"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 1),
                'color' => "#ffb300"
            ]
        );

        // QARs In Progress
        array_push(
            $series,
            [
                //'type' => 'column',
                'name' => Yii::t("app", "In Progress"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 2),
                'color' => "#03a9f4"
            ]
        );


        // QARs Completed
        array_push(
            $series,
            [
                //'type' => 'column',
                'name' => Yii::t("app", "Completed"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 3),
                "color" => "#26a69a"
            ]
        );

        // QARs Average
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Average QAR"),
                'data' => Qar::getAverageQarByTimePeriod($period),
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white'
                ]
            ]
        );


        // Pie chart
        array_push(
            $series,
            [
                'type' => 'pie',
                'name' => 'Total QARs',
                'title' => false,
                'data' => [
                    [
                        'name' => Yii::t("app", "To Be Done") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[0]['data']),
                        'color' => "#ffb300"
                    ],
                    [
                        'name' => Yii::t("app", "In Progress") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[1]['data']),
                        'color' => "#03a9f4"
                    ],
                    [
                        'name' => Yii::t("app", "Completed") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[2]['data']),
                        'color' => "#26a69a"
                    ],
                ],
                'center' => [30, 30],
                'size' => 100,
                'showInLegend' => false,
                'dataLabels' => [
                    'enabled' => false
                ],
                'visible' => false
            ]
        );

        return $series;
    }

    public static function getQarPieChart($period, $siteId = null)
    {

        $series  = [];

        // QARs To-Be Done
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "To Be Done"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 1),
                'color' => "#ffb300",
                'visible' => false,
                'showInLegend' => false
            ]
        );

        // QARs In Progress
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "In Progress"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 2),
                'color' => "#03a9f4",
                'visible' => false,
                'showInLegend' => false
            ]
        );


        // QARs Completed
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "Completed"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 3),
                "color" => "#26a69a",
                'visible' => false,
                'showInLegend' => false
            ]
        );

        // QARs Average
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Average QAR"),
                'data' => Qar::getAverageQarByTimePeriod($period),
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white'
                ],
                'visible' => false,
                'showInLegend' => false
            ]
        );


        // Pie chart
        array_push(
            $series,
            [
                'type' => 'pie',
                'name' => 'Total QARs',
                'title' => false,
                'data' => [
                    [
                        'name' => Yii::t("app", "To Be Done") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[0]['data']),
                        'color' => "#ffb300"
                    ],
                    [
                        'name' => Yii::t("app", "In Progress") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[1]['data']),
                        'color' => "#03a9f4"
                    ],
                    [
                        'name' => Yii::t("app", "Completed") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[2]['data']),
                        'color' => "#26a69a"
                    ],
                ],
                //'center' => [30, 30],
                'size' => 200,
                'showInLegend' => true,
                'dataLabels' => [
                    'enabled' => false
                ]
            ]
        );

        return $series;
    }

    public static function getSitesChart($startDate = null, $endDate= null, $siteId = null, $countryCode = null)
    {
        $series  = '[' ;

        $departments = Department::find()->where(["country_code" => $countryCode])->asArray()->all();

        foreach($departments as $key => $department) {
            $row = "[\"". strtolower($countryCode) . "-" . strtolower($department["postal_code"]) . "\"," . (float) Qar::getAverageQarByPeriodStartDateAndEndDate($startDate, $endDate, $siteId, $department["id"]) . "]" . ($key < count($departments)-1 ? "," : "") ;
            $series.= $row;
        }
       return $series. "]";
    }


    public static function getSitesKorWithLocationChart($startDate = null, $endDate= null, $siteId = null, $countryCode = null)
    {

        $series  = '[' ;

        $departments = Department::find()->where(["country_code" => $countryCode])->asArray()->all();



        $rtn_array = [];

        foreach($departments as $key => $department) {

            $data = Qar::getKorAndLocationByPeriodStartDateAndEndDate($startDate, $endDate, $siteId, $department["id"]);

            $samples = array_map(function($item){
                return $item["sample_number"];
            }, $data);

            foreach (array_unique($samples) as $key=>$sample){

                $dataOfThisSample = array_filter($data, function($item) use ($sample){
                   return $item["sample_number"]  == $sample;
                });

                $korArray = array_filter($dataOfThisSample, function ($item){
                    return $item["key"] == Qar::RESULT_KOR;
                });

                $lat_array = array_filter($dataOfThisSample, function ($item){
                    return $item["key"] == Qar::FIELD_LOCATION_LATITUDE;
                });

                $long_array = array_filter($dataOfThisSample, function ($item){
                    return $item["key"] == Qar::FIELD_LOCATION_LONGITUDE;
                });

                if(!empty($korArray) && !empty($lat_array) && !empty($long_array)){
                    $series .= '{\'name\' : \''. array_values($korArray)[0] ["site_name"]. '\','. '\'kor\' :'. (array_values($korArray)[0] ["value"]) .', ' . '\'lat\':'. (array_values($lat_array)[0] ["value"]). ','. '\'lon\':'. (array_values($long_array)[0] ["value"]). "},";
                }
            }
        }

        return $series ."]";
    }

    public static function getUsersChart($period)
    {
        $series = [];


        // Institution Admin
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Institution Admin"),
                'data' => User::getUsersCountsByPeriodAndRole($period, User::ROLE_INSTITUTION_ADMIN),
                'color' => "#03a9f4"
            ]
        );

        // Institution Admin View
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Institution Admin View"),
                'data' => User::getUsersCountsByPeriodAndRole($period, User::ROLE_INSTITUTION_ADMIN_VIEW),
                'color' => "#aa66cc"
            ]
        );

        // Buyers
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Buyers"),
                'data' => User::getUsersCountsByPeriodAndRole($period, User::ROLE_FIELD_BUYER),
                'color' => "#25476a"
            ]
        );

        // Field Tech
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "FieldTech"),
                'data' => User::getUsersCountsByPeriodAndRole($period, User::ROLE_FIELD_TECH),
                'color' => "#ffb300"
            ]
        );

        // Farmers
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Farmers"),
                'data' => User::getUsersCountsByPeriodAndRole($period, User::ROLE_FIELD_FARMER),
                'color' => "#26a69a"
            ]
        );

        return $series;

    }
}
