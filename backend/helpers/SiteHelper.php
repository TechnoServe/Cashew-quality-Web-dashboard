<?php


namespace backend\helpers;

use backend\models\Qar;
use yii\web\JsExpression;
use Yii;

class SiteHelper
{

    public static function getQarChart($period, $siteId = null)
    {

        $series  = [];

        // QARs To-Be Done
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "To Be Done"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 1),
                'color' => "#ffb300"
            ]
        );

        // QARs In Progress
        array_push(
            $series,
            [
                'type' => 'column',
                'name' => Yii::t("app", "In Progress"),
                'data' => Qar::getQarCountsByStatusAndTimePeriod($period, 2),
                'color' => "#03a9f4"
            ]
        );


        // QARs Completed
        array_push(
            $series,
            [
                'type' => 'column',
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
                'showInLegend' => true,
                'dataLabels' => [
                    'enabled' => false
                ]
            ]
        );

        return $series;
    }

    public static function getSitesChart($period, $siteId = null)
    {
        $series  = [];

        // QARs Average
        array_push(
            $series,
            [
                'data' => Qar::getAverageQarByTimePeriod($period, 1)
    
            ]
        );

        // Sum
        array_push(
            $series,
            [
                'data' => [
                    array_sum($series[0]['data'])
                ]
            ]
        );

        return $series[1];
    }
}
