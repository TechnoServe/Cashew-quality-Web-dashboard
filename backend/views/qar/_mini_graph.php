<?php

use common\helpers\CashewAppHtmlHelper;
use dosamigos\highcharts\HighCharts;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

?>

<?=
    \dosamigos\highcharts\HighCharts::widget([
        'clientOptions' => [
            'chart' => [
                'type' => 'column'
            ],
            'title' => [
                'text' => 'QARs chart'
            ],
            'credits' => [
                'enabled' => false
            ],
            'xAxis' => [
                'type' => 'datetime'
            ],
            'yAxis' => [
                'title' => [
                    'text' => 'Qars'
                ]
            ],
            'plotOptions' => [
                'series' => [
                    //'pointStart' => $startDate,
                    'pointIntervalUnit' => 'day'
                ],
            ],
            'labels' => [
                'items' => [
                    [
                        'html' => 'Total QARs',
                        'style' => [
                            'left' => '50px',
                            'top' => '18px',
                            'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                        ],
                    ],
                ],
            ],
            'series' => [
                [
                    'type' => 'column',
                    'name' => 'To-be Done',
                    'data' => [3, 2, 1, 3, 4, 1, 4]

                ],
                [
                    'type' => 'column',
                    'name' => 'In Progress',
                    'data' => [2, 3, 5, 7, 6, 2, 5]
                ],
                [
                    'type' => 'column',
                    'name' => 'Completed',
                    'data' => [4, 3, 3, 9, 4, 9, 4]
                ],
                [
                    'type' => 'spline',
                    'name' => 'Average',
                    'data' => [4.5, 4, 4.5, 9.5, 7, 6, 6.5],
                    'marker' => [
                        'lineWidth' => 2,
                        'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                        'fillColor' => 'white'
                    ]
                ],
                [
                    'type' => 'pie',
                    'name' => 'Total QARs',
                    'data' => [
                        [
                            'name' => 'To-be Done',
                            'y' => 18,
                            'color' => new JsExpression('Highcharts.getOptions().colors[0]') // To-be Done's color
                        ],
                        [
                            'name' => 'In Progress',
                            'y' => 30,
                            'color' => new JsExpression('Highcharts.getOptions().colors[1]') // In-Progress's color
                        ],
                        [
                            'name' => 'Completed',
                            'y' => 36,
                            'color' => new JsExpression('Highcharts.getOptions().colors[2]') // Completed's color
                        ],
                    ],
                    'center' => [100, 80],
                    'size' => 100,
                    'showInLegend' => false,
                    'dataLabels' => [
                        'enabled' => false
                    ]
                ],
            ]
        ]
    ]);
