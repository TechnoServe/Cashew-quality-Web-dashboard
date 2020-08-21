<?php
use yii\web\JqueryAsset;
$this->registerJsFile("https://code.highcharts.com/mapdata/countries/".strtolower($country_code)."/" . strtolower($country_code) . "-all.js", ["depends"=>JqueryAsset::className()]) ?>

<script src="https://code.highcharts.com/maps/highmaps.js"></script>

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