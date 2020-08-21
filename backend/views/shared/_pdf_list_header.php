<?php

use yii\helpers\Html;

?>
<!--Pdf heading-->
<div style="width: 80%; margin: 0 auto; text-align: center;">
    <?=Html::img( Yii::$app->params[ 'MPDF_IMAGE_BASE_URL'] . '/img/logo.png', ['width'=>'150'])?>
    <h3 style="margin-top: 20px; text-transform: uppercase"><?=$title?></h3>
</div>