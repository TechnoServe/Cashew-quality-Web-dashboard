<?php

use dosamigos\highcharts\HighCharts;
?>
<?=
    \dosamigos\highcharts\HighCharts::widget([
        'clientOptions' => [
            'chart' => [
                //'type' => 'bar'
            ],
            'title' => [
                'text' => 'QARs chart'
            ],
            'xAxis' => [
                'categories' => [
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday',
                    'Sunday'
                ]
            ],
            'yAxis' => [
                'title' => [
                    'text' => 'Qars'
                ]
            ],
            'labels' => [
                'items' => [
                    [
                        'html' => 'Total QARs',
                        'style' => [
                            'left' => '50px',
                            'top' => '18px',
                            //'color' => 
                        ]
                    ]
                ]
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
                        //'lineColor' => ,
                        'fillColor' => 'white'
                    ]
                ],
                [
                    'type' => 'pie',
                    'name' => 'Total QARs',
                    'data' => [
                        [
                            'name' => 'To-be Done',
                            'y' => 13,
                            //'color' => 
                        ],
                        [
                            'name' => 'In Progress',
                            'y' => 23,
                            //'color' => 
                        ],
                        [
                            'name' => 'Completed',
                            'y' => 19,
                            //'color' => 
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
