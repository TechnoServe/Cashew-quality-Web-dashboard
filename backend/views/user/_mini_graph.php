<?=
    \dosamigos\highcharts\HighCharts::widget([
        'clientOptions' => [
            'chart' => [
                'type' => 'column'
            ],

            'title' => [
                'text' => 'Users chart'
            ],

            'credits' => [
                'enabled' => false
            ],

            'xAxis' => [
                'categories' => $categories
            ],

            'yAxis' => [
                'title' => [
                    'text' => 'Users'
                ]
            ],

            'series' => $userSeries
        ]
    ]);
