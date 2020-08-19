<html>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.6/proj4.js"></script>
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/maps/modules/data.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
    <script src="https://code.highcharts.com/mapdata/countries/bj/bj-all.js"></script>
</head>

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

<body>

    <div class="container">
        <div id="map-container"></div>
    </div>

    <script>
        var data = [
            ['bj-do', 0], // Donga
            ['bj-bo', 1], // Borgou
            ['bj-al', 2], // Alibori
            ['bj-cl', 3], // Collines
            ['bj-aq', 4], // Atlantique
            ['bj-li', 5], // Littoral
            ['bj-cf', 6], // Kouffo
            ['bj-ou', 7], // Ouémé
            ['bj-zo', 8], // Zou
            ['bj-pl', 9], // Plateau
            ['bj-mo', 10], // Mono
            ['bj-ak', 11] // Atakora
        ];

        Highcharts.mapChart('map-container', {
            chart: {
                map: 'countries/bj/bj-all'
            },

            title: {
                text: 'Heatmap for KOR Average per site'
            },

            credits: {
                enabled: false
            },

            tooltip: {
                headerFormat: '',
                pointFormat: 'Site: <b>{point.name}</b>, Location: <b>{point.name}</b><br>Lat: <b>{point.properties.latitude}</b>, Lon: <b>{point.properties.longitude}</b><br>KOR: <b>{point.properties.hasc}</b>'
            },

            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'top'
                }
            },

            colorAxis: {
                min: 0
            },

            //series: $siteSeries,

            series: [{
                data: data,
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
    </script>

</body>

</html>