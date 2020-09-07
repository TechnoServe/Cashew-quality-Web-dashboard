<?php

use yii\web\JqueryAsset;

$this->registerJsFile("https://code.highcharts.com/mapdata/countries/" . strtolower($country_code) . "/" . strtolower($country_code) . "-all.js", ["depends" => JqueryAsset::className()]) ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.6/proj4.js"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/marker-clusters.js"></script>
<script src="https://code.highcharts.com/modules/coloraxis.js"></script>

<style>
    #map-container2 {
        height: 800px;
        min-width: 310px;
        max-width: 100%;
        margin: 0 auto;
    }


    #map-container {
        height: 800px;
        min-width: 310px;
        max-width: 100%;
        margin: 0 auto;
    }
</style>

<div id="map-container" class="col-md-6"></div>
<div id="map-container2" class="col-md-6"></div>

<?php $this->registerJs("
    
      Highcharts.mapChart('map-container', {
            chart: {
                map: 'countries/" . strtolower($country_code) . "/".strtolower($country_code)."-all'
            },

            title: {
                text: null
            },

            credits: {
                enabled: false
            },

            // tooltip: {
            //     headerFormat: '',
            //     pointFormat: 'Site: <b>{point.name}</b>, Location: <b>{point.name}</b><br>Lat: <b>{point.properties.latitude}</b>, Lon: <b>{point.properties.longitude}</b><br>KOR: <b>{point.properties.hasc}</b>'
            // },

            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'top'
                }
            },

            colorAxis: {
                min: 0
            },

            series: [{
                data: " . $siteSeries . ",
                name: 'Average of KOR',
                states: {
                    hover: {
                        color: '#BADA55'
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }]
        });
    
    ") ?>

<?php $this->registerJs("

    var data = ". $korLocations .";

        Highcharts.mapChart('map-container2', {
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

