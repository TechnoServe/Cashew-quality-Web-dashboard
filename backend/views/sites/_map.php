<?php

use yii\web\JqueryAsset;

$this->registerJsFile("https://code.highcharts.com/mapdata/countries/" . strtolower($country_code) . "/" . strtolower($country_code) . "-all.js", ["depends" => JqueryAsset::className()])
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.6/proj4.js"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/modules/marker-clusters.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/heatmap.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
    #map-container {
        height: 800px;
        min-width: 310px;
        max-width: 800px;
        margin: 0 auto;
    }

    #map-container2 {
        height: 400px;
        min-width: 310px;
        max-width: 800px;
    }

    .highcharts-figure, .highcharts-data-table table {
        min-width: 360px; 
        max-width: 800px;
        margin: 1em auto;
    }
    .highcharts-data-table table {
	    font-family: Verdana, sans-serif;
	    border-collapse: collapse;
	    border: 1px solid #EBEBEB;
	    margin: 10px auto;
	    text-align: center;
	    width: 100%;
	    max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
	    font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>

<div id="map-container" class="col-md-6"></div>
<div id="map-container2" class="col-md-6"></div>

<?php

$this->registerJs("

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
                map: 'countries/". strtolower($country_code) . "/" . strtolower($country_code) . "-all'
            },
                
            title: {
                text: 'Heatmap for KOR Average per site'
            },

            credits: {
                enabled: false
            },

            tooltip: {
                header: '',
                pointFormat: '<b>{point.name}</b><br>Lat: {point.lat:.2f}, Lon: {point.lon:.2f}<br>".Yii::t("app", 'Average KOR').": <b>{point.kor:.2f}</b>'
            },

            mapNavigation: {
                enabled: true
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

            series: [
            {
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
                name: 'Sites',
                data: data,
                marker: {
                    symbol: 'url(http://maps.google.com/mapfiles/ms/icons/red-dot.png)'
                }
            }]
        });

")

?>

<?php

$this->registerJs("

    function getPointCategoryName(point, dimension) {
        var series = point.series,
            isY = dimension === 'y',
            axis = series[isY ? 'yAxis' : 'xAxis'];
        return axis.categories[point[isY ? 'y' : 'x']];
    }

    Highcharts.chart('map-container2', {

        chart: {
            type: 'heatmap',
            marginTop: 40,
            marginBottom: 80,
            plotBorderWidth: 1
        },

        title: {
            text: 'KOR Average per region and period'
        },

        credits: {
            enabled: false
        },

        xAxis: {
            categories: ['Donga', 'Borgou', 'Alibori', 'Collines', 'Atlantique', 'Littoral', 'Kouffo', 'Ouémé', 'Zou', 'Plateau', 'Mono', 'Atakora']
        },

        yAxis: {
            categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            title: null,
            reversed: true
        },

        accessibility: {
            point: {
                descriptionFormatter: function (point) {
                    var ix = point.index + 1,
                        xName = getPointCategoryName(point, 'x'),
                        yName = getPointCategoryName(point, 'y'),
                        val = point.value;
                    return ix + '. ' + xName + ' sales ' + yName + ', ' + val + '.';
                }
            }
        },

        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[0]
        },

        legend: {
            align: 'right',
            layout: 'vertical',
            margin: 0,
            verticalAlign: 'top',
            y: 25,
            symbolHeight: 280
        },

        tooltip: {
            formatter: function () {
                return '<b>' + getPointCategoryName(this.point, 'x') + '</b> got <br><b>' +
                    this.point.value + '</b> KOR on <br><b>' + getPointCategoryName(this.point, 'y') + '</b>';
            }
        },

        series: [{
            name: 'KOR per region',
            borderWidth: 1,
            data: [
                [0, 0, 10], [0, 1, 19], [0, 2, 8], [0, 3, 24], [0, 4, 67], [0, 5, 16], [0, 6, 91],
                [1, 0, 92], [1, 1, 58], [1, 2, 78], [1, 3, 117], [1, 4, 48], [1, 5, 37], [1, 6, 65],
                [2, 0, 35], [2, 1, 15], [2, 2, 123], [2, 3, 64], [2, 4, 52], [2, 5, 95], [2, 6, 87],
                [3, 0, 72], [3, 1, 132], [3, 2, 114], [3, 3, 19], [3, 4, 16], [3, 5, 84], [3, 6, 11],
                [4, 0, 38], [4, 1, 5], [4, 2, 8], [4, 3, 117], [4, 4, 115], [4, 5, 16], [4, 6, 8],
                [5, 0, 88], [5, 1, 32], [5, 2, 12], [5, 3, 6], [5, 4, 120], [5, 5, 4], [5, 6, 60],
                [6, 0, 13], [6, 1, 44], [6, 2, 88], [6, 3, 98], [6, 4, 96], [6, 5, 30], [6, 6, 77],
                [7, 0, 31], [7, 1, 1], [7, 2, 82], [7, 3, 32], [7, 4, 30], [7, 5, 36], [7, 6, 35],
                [8, 0, 85], [8, 1, 97], [8, 2, 123], [8, 3, 64], [8, 4, 84], [8, 5, 59], [8, 6, 56],
                [9, 0, 47], [9, 1, 114], [9, 2, 31], [9, 3, 48], [9, 4, 91], [9, 5, 26], [9, 6, 78],
                [10, 0, 63], [10, 1, 12], [10, 2, 79], [10, 3, 101], [10, 4, 16], [10, 5, 28], [10, 6, 6],
                [11, 0, 25], [11, 1, 68], [11, 2, 42], [11, 3, 3], [11, 4, 111], [11, 5, 5], [11, 6, 99]
            ],
            dataLabels: {
                enabled: true,
                color: '#000000'
            }
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    yAxis: {
                        labels: {
                            formatter: function () {
                                return this.value.charAt(0);
                            }
                        }
                    }
                }
            }]
        }

    });

")

?>