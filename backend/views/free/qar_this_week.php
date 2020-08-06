<?php
use miloschuman\highcharts\Highcharts;

/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 8/29/18
 * Time: 3:26 PM
 */
?>

<?php
$this_month = date('Y F ');
echo Highcharts::widget([
    'htmlOptions' => [
        'class' => 'this-week',
    ],
    'options' => [
        'credits' => [
            'enabled' => false
        ],
        'chart' => [
            'type' => 'column',
        ],
        'title' => [
            'text' => 'This Weekly Report',
            'align' => 'center'
        ],
        'xAxis' => [
            [
                'categories' => ['Location 1','Location 2','Location 3','Location 1','Location 2','Location 3','Location 1','Location 2','Location 3']
            ]
        ],
        'yAxis' => [
            'title' => [
                'min' => 0,
                'text' => 'Number of QAR',
                'style' => [
                    'color' => 'black'
                ]
            ],
        ],
        'tooltip' => [
            'shared' => true
        ],
        'plotOptions' => [
            'column' => [
                'pointPadding' => 0.05,
                'borderWidth' => 0,
            ],
        ],
        'colors' => [
            Yii::$app->params['yellow_color'],
            Yii::$app->params['blue_color'],
            Yii::$app->params['green_color'],
            Yii::$app->params['red_color'],
        ],
        'series' => [
            [
                'name' => 'To be Done',
                'type' => 'column',
                'data' => [3,2,1,3,2,1,3,2,1],
            ],
            [
                'name' => 'In Progress',
                'type' => 'column',
                'data' => [21,4,7,21,4,7,21,4,7],
            ],
            [
                'name' => 'Completed',
                'type' => 'column',
                'data' => [8,4,11,8,4,11,8,4,11],
            ],
            [
                'name' => 'Canceled',
                'type' => 'column',
                'data' => [8,10,2,8,10,2,8,10,2],
            ],

            [
                'type' => 'spline',
                          'name' => 'KOR',
                          'data' => [4, 2.67, 8, 4, 2.67, 8, 4, 2.67, 8],
                             'marker' => [
                                      'lineWidth' => 2,
                                      'lineColor' => Yii::$app->params['dark_blue_color'],
                                      'fillColor' => 'white',
                                         ],
                          'color' => Yii::$app->params['dark_blue_color'],
            ],
        ],
        'responsive' => [
            'rules' => [
                [
                    'condition' => [
                        'maxWidth' => 500
                    ],
                    'chartOptions' => [
                        'legend' => [
                            'floating' => false,
                            'layout' => 'horizontal',
                            'align' => 'center',
                            'verticalAlign' => 'bottom',
                            'x' => 0,
                            'y' => 0
                        ],
                        'yAxis' => [
                            [
                                'labels' => [
                                    'align' => 'right',
                                    'x' => 0,
                                    'y' => -6
                                ],
                                'showLastLabel' => false
                            ],
                            [
                                'labels' => [
                                    'align' => 'left',
                                    'x' => 0,
                                    'y' => -6
                                ],
                                'showLastLabel' => false
                            ],
                            [
                                'visible' => false
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
]);

?>




