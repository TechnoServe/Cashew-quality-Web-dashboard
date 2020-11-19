<?php


namespace backend\helpers;

use backend\models\FreeQar;
use yii\web\JsExpression;
use Yii;

class FreeVersionDataHelper
{

    public static function getQarChartData($datesPeriod, $siteId = null){

        $series  = [];

        // Add to be done
        array_push($series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "To be done"),
                'data' => \backend\models\FreeQar::getQarCountsByStatusAndTimePeriod($datesPeriod, 0, $siteId),
                "color" => "#ffb300"
            ]
        );

        // Add in progress
        array_push($series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "In progress"),
                'data' => \backend\models\FreeQar::getQarCountsByStatusAndTimePeriod($datesPeriod, 1, $siteId),
                "color" => "#03a9f4"
            ]
        );


        // Completed
        array_push($series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "Completed"),
                'data' => \backend\models\FreeQar::getQarCountsByStatusAndTimePeriod($datesPeriod, 2, $siteId),
                "color" => "#26a69a"
            ]
        );

        //Average qar
        array_push($series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Average KOR"),
                'data' => \backend\models\FreeQar::getAverageKorOfQarByTimePeriod($datesPeriod, $siteId),
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white'
                ]
            ]
        );


        //Pie chart
        array_push($series,
            [
                'type' => 'pie',
                'name' => Yii::t("app", "Number"),
                'title' => false,
                'data' => [
                    [
                        'name' => Yii::t("app", "To be done") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[0]['data']),
                        "color" => "#ffb300"
                    ],
                    [
                        'name' => Yii::t("app", "In progress") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[1]['data']),
                        "color" => "#03a9f4"
                    ],
                    [
                        'name' => Yii::t("app", "Completed") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[2]['data']),
                        "color" => "#26a69a"
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

    public static function getQarPieChartData($datesPeriod, $siteId = null)
    {

        $series  = [];

        // Add to be done
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "To be done"),
                'data' => \backend\models\FreeQar::getQarCountsByStatusAndTimePeriod($datesPeriod, 0, $siteId),
                "color" => "#ffb300",
                'visible' => false,
                'showInLegend' => false
            ]
        );

        // Add in progress
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "In progress"),
                'data' => \backend\models\FreeQar::getQarCountsByStatusAndTimePeriod($datesPeriod, 1, $siteId),
                "color" => "#03a9f4",
                'visible' => false,
                'showInLegend' => false
            ]
        );


        // Completed
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "Completed"),
                'data' => \backend\models\FreeQar::getQarCountsByStatusAndTimePeriod($datesPeriod, 2, $siteId),
                "color" => "#26a69a",
                'visible' => false,
                'showInLegend' => false
            ]
        );

        //Average qar
        array_push(
            $series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Average KOR"),
                'data' => \backend\models\FreeQar::getAverageKorOfQarByTimePeriod($datesPeriod, $siteId),
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white'
                ],
                'visible' => false,
                'showInLegend' => false
            ]
        );


        //Pie chart
        array_push(
            $series,
            [
                'type' => 'pie',
                'name' => Yii::t("app", "Number"),
                'title' => false,
                'data' => [
                    [
                        'name' => Yii::t("app", "To be done") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[0]['data']),
                        "color" => "#ffb300"
                    ],
                    [
                        'name' => Yii::t("app", "In progress") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[1]['data']),
                        "color" => "#03a9f4"
                    ],
                    [
                        'name' => Yii::t("app", "Completed") . "(" . Yii::t("app", "Total") . ")",
                        'y' => array_sum($series[2]['data']),
                        "color" => "#26a69a"
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

    public static function getUsersChartData($datesPeriod){

        $series  = [];

        // Add to be done
        array_push($series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "Buyers"),
                'data' => \backend\models\FreeUser::getUsersCountsByRoleAndTimePeriod($datesPeriod, 2),
                'color' => "#26a69a"
            ]
        );

        // Add in progress
        array_push($series,
            [
                'type' => 'spline',
                'name' => Yii::t("app", "FieldTech"),
                'data' => \backend\models\FreeUser::getUsersCountsByRoleAndTimePeriod($datesPeriod, 1),
                'color' =>"#25476a"
            ]
        );
        return $series;
    }

    public static function getKorLocations($startDate = null, $endDate = null, $countryCode = null)
    {

        $kor_country = FreeQar::getKorsAndLocations($startDate, $endDate, $locationFilters = ["location_country_code" => $countryCode], $rtn = "list");
        $series = '[' ;

        $rtn_array = [];

        foreach ($kor_country as $key => $value) {
            $series .= '{"region": "' . $value['location_region'] . '", "name": "' . $value['name'] . '", "lat": ' . $value['location_lat'] . ', "lon": ' . $value['location_lon']. ', "country":"'  . $value['location_country_code']. '", "kor":' . $value['kor'] . '}' . ($key < (count($kor_country)-1) ? "," : "");
        }

        return $series ."]";
    }

    public static function getKorTableHeatMap($startDate, $endDate, $countryCode = null)
    {
        $series = [] ;

        array_push(
            $series,
            [
                'name' => 'KOR per region',
                'borderWidth' => 1,
                'data' => FreeQar::getKorsAndLocations($startDate, $endDate, $locationFilters = ["location_country_code" => $countryCode], $rtn = "list")
            ]
        );

        return $series;
    }
}