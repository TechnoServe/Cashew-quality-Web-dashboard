<?php

use yii\web\JqueryAsset;

$this->registerJsFile("https://code.highcharts.com/mapdata/countries/" . strtolower($country_code) . "/" . strtolower($country_code) . "-all.js", ["depends" => JqueryAsset::className()]) ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.6/proj4.js"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/marker-clusters.js"></script>
<script src="https://code.highcharts.com/modules/coloraxis.js"></script>

<style>
    #map-container {
        height: 800px;
        min-width: 310px;
        max-width: 800px;
        margin: 0 auto;
    }

    .loading {
        margin-top: 10em;
        text-align: center;
        color: gray;
    }
</style>


<div class="container">
    <div id="map-container"></div>
</div>
<?php $this->registerJs("

    var data = [
        {
            'name' : 'Alibori',
            'lat' : 11.4305,
            'lon' : 2.92598,
            'kor' : 92.598
        },
        {
            'name' : 'Kandi',
            'lat' : 11.3305,
            'lon' : 2.83598,
            'kor' : 93.598
        },
        {
            'name' : 'Site 3',
            'lat' : 11.7305,
            'lon' : 2.84598,
            'kor' : 94.598
        },
        {
            'name' : 'Site 4',
            'lat' : 11.8305,
            'lon' : 2.95598,
            'kor' : 95.598
        },
        {
            'name' : 'Site 5',
            'lat' : 11.2305,
            'lon' : 2.96598,
            'kor' : 92.598
        },
        {
            'name' : 'Site 6',
            'lat' : 11.5305,
            'lon' : 2.96598,
            'kor' : 92.598
        },
        {
            'name' : 'Site 7',
            'lat' : 11.6305,
            'lon' : 2.96598,
            'kor' : 96.513
        },
        {
            'name' : 'Atakora',
            'lat' : 10.7035,
            'lon' : 1.55782,
            'kor' : 155.782
        },
        {
            'name' : 'Atlantique',
            'lat' : 6.61657,
            'lon' : 2.22263,
            'kor' : 66.1657
        },
        {
            'name' : 'Borgou',
            'lat' : 9.80668,
            'lon' : 2.90363,
            'kor' : 98.0668
        },
        {
            'name' : 'Collines',
            'lat' : 8.005129999999999,
            'lon' : 2.17251,
            'kor' : 80.051299
        },
        {
            'name' : 'Kouffo',
            'lat' : 6.98499,
            'lon' : 1.81235,
            'kor' : 69.8499
        },
        {
            'name' : 'Donga',
            'lat' : 9.315060000000001,
            'lon' : 1.77142,
            'kor' : 93.1506
        },
        {
            'name' : 'Littoral',
            'lat' : 6.36623,
            'lon' : 2.42192,
            'kor' : 63.6623
        },
        {
            'name' : 'Mono',
            'lat' : 6.48568,
            'lon' : 1.79465,
            'kor' : 179.465
        },
        {
            'name' : 'Ouémé',
            'lat' : 6.59423,
            'lon' : 2.55171,
            'kor' : 255.171
        },
        {
            'name' : 'Plateau',
            'lat' : 7.15213,
            'lon' : 2.60483,
            'kor': 260.483
        },
        {
            'name' : 'Zou',
            'lat' : 7.22681,
            'lon' : 2.09135,
            'kor' : 72.2681
        }
    ];

        Highcharts.mapChart('map-container', {
            chart: {
                map: 'countries/" . strtolower($country_code) . "/" . strtolower($country_code) . "-all'
            },
            title: {
                text: null
            },
            credits: {
                enabled: false
            },
            mapNavigation: {
                enabled: true
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '<b>{point.name}</b><br>Lat: {point.lat:.2f}, Lon: {point.lon:.2f}<br>Average KOR: <b>{point.kor:.2f}</b>'
            },
            colorAxis: {
                min: 0,
                max: 10
            },
            plotOptions: {
                mappoint: {
                    cluster: {
                        enabled: true,
                        allowOverlap: false,
                        animation: {
                            duration: 450
                        },
                        layoutAlgorithm: {
                            type: 'grid',
                            gridSize: 70
                        },
                        zones: [{
                            from: 1,
                            to: 4,
                            marker: {
                                radius: 13
                            }
                        }, {
                            from: 5,
                            to: 9,
                            marker: {
                                radius: 15
                            }
                        }, {
                            from: 10,
                            to: 15,
                            marker: {
                                radius: 17
                            }
                        }, {
                            from: 16,
                            to: 20,
                            marker: {
                                radius: 19
                            }
                        }, {
                            from: 21,
                            to: 100,
                            marker: {
                                radius: 21
                            }
                        }]
                    }
                }
            },
            series: [{
                name: 'Basemap',
                borderColor: '#A0A0A0',
                nullColor: 'rgba(177, 244, 177, 0.5)',
                showInLegend: false
            }, {
                type: 'mappoint',
                dataLabels: {                   
                    format: '{point.kor:.2f}',
                    // style: {
                    //     color: 'white'
                    // }
                },
                enableMouseTracking: true,
                colorKey: 'clusterPointsAmount',
                name: 'Cities',
                data: data,
                marker: {
                    symbol: 'url(http://maps.google.com/mapfiles/ms/icons/red-dot.png)'
                }
            }]
        });
    
") ?>

