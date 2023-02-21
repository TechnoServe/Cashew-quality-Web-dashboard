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
        max-width: 100%;
        margin: 0 auto;
    }

    #map-container2 {
        height: 400px;
        min-width: 310px;
        max-width: 100%;
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

    var data = ". $kor_locations .";

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
                pointFormat: 'Region: <b>{point.region}</b><br>Site: <b>{point.name}</b><br>Lat: <b>{point.lat:.2f}</b>, Lon: <b>{point.lon:.2f}</b><br>KOR: <b>{point.kor}</b>'
            },

            mapNavigation: {
                enabled: true
            },

            colorAxis: {
                min: 0,
                max: 10
            },
            
            legend: {
                enabled: false
            },

            series: [
            {
                name: 'Basemap',
                borderColor: '#A0A0A0',
                nullColor: 'rgba(177, 244, 177, 0.5)',
                showInLegend: false
            }, {
                type: 'mappoint',
                enableMouseTracking: true,
                colorKey: 'clusterPointsAmount',
                name: 'KOR Average',
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
            categories: ['". implode('\',\'', $categories) ."']
        },

        yAxis: {
            categories: ['". implode('\',\'', $regions) ."'],
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
                    return ix + '. ' + xName + ' gets ' + yName + ', ' + val + '.';
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
            data: $tableSeries,
            dataLabels: {
                enabled: true,
                format: '{point.value:.2f}',
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