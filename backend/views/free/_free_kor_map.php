<?php


use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;

$map = new Map([
    'center' => new LatLng([ "lat" => $siteKorMarkers["center"][0], "lng" => (double)$siteKorMarkers["center"][1]]),
    'zoom' => 8,
    'width' => '100%',
    "mapTypeId" => new \yii\web\JsExpression("google.maps.MapTypeId.HYBRID")
]);


foreach ($siteKorMarkers["markers"] as $key => $markerData){
    // Lets add a marker now
    $marker = new Marker([
        'position' => new LatLng([ "lat" => $markerData["position"][0], "lng" => (double)$markerData["position"][1]]),
        'title' => $markerData["title"],
        'label' =>"\"" . $markerData['kor'] ."\"",
        "optimized" => false
    ]);

// Provide a shared InfoWindow to the marker
    $marker->attachInfoWindow(
        new InfoWindow([
            'content' => '<div> 
                            <strong style="font-size: 20px; color: #25476a;">'. $markerData["kor"]  . "</strong>" .
                            '<br>' .
                            '<strong>'. $markerData["title"]  . "</strong>" .
                                '<br>' .
                            '<small>'. strtoupper(Yii::t("app", "Lotitude")). ": " .  $markerData["lat"]  . "</small>" .
                                 '<br>' .
                             '<small>'. strtoupper(Yii::t("app", "Longitude")). ": " .  $markerData["lon"]  . "</small>" .
                                '<br>' .
                             '<small>'. strtoupper(Yii::t("app", "Accuracy")). ": " .  $markerData["acc"]  . "</small>" .
                        '</div>'
        ])
    );

    // Add marker to the map
    $map->addOverlay($marker);
}

// Display the map -finally :)
echo $map->display();
?>
