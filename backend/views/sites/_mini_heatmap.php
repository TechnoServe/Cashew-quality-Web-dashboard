<?php

use yii\web\JqueryAsset;

$this->registerJsFile("https://code.highcharts.com/mapdata/custom/europe.js", ["depends" => JqueryAsset::className()]) ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.6/proj4.js"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/mapdata/custom/europe.js"></script>
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

    Highcharts.getJSON('https://cdn.jsdelivr.net/gh/highcharts/highcharts@1e9e659c2d60fbe27ef0b41e2f93112dd68fb7a3/samples/data/european-train-stations-near-airports.json', function(data) {
        Highcharts.mapChart('map-container', {
            chart: {
                map: 'custom/europe'
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
                pointFormat: '<b>{point.name}</b><br>Lat: {point.lat:.2f}, Lon: {point.lon:.2f}'
            },
            colorAxis: {
                min: 0,
                max: 20
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
                enableMouseTracking: true,
                colorKey: 'clusterPointsAmount',
                name: 'Cities',
                data: data
            }]
        });
    });
") ?>