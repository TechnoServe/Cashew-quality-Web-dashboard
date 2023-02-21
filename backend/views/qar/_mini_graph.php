<?=
    \dosamigos\highcharts\HighCharts::widget([
        'clientOptions' => [
            'chart' => [
                'type' => 'column'
            ],

            'title' => [
                'text' => null
            ],

            'credits' => [
                'enabled' => false
            ],

            'xAxis' => [
                'categories' => $categories
            ],

            'yAxis' => [
                'title' => [
                    'text' => 'Qars'
                ]
            ],

            'series' => $qarSeries
        ]
    ]);
?>

