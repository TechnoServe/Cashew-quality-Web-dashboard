<?=
\dosamigos\highcharts\HighCharts::widget([
    'clientOptions' => [
        'chart' => [
            'type' => 'pie',
            "marginRight" => 0,
            "marginTop" => 0,
            "marginLeft" => 0,
            "marginBottom" => 0
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
                'text' => null
            ]
        ],
        'series' => $qarPieSeries,
        "size" => "80%",
        "showInLegend" => true,
    ]
]);
?>