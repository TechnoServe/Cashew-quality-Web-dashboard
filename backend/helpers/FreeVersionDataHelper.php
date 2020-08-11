<?php


namespace backend\helpers;


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
}