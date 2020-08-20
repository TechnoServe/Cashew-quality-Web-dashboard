<?php

use backend\models\Qar;
use common\helpers\CashewAppHtmlHelper;
use dosamigos\highcharts\HighCharts;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

?>

<?=
    \dosamigos\highcharts\HighCharts::widget([
        'clientOptions' => [
            'chart' => [
                'type' => 'column'
            ],

            'title' => [
                'text' => 'QARs chart'
            ],

            'credits' => [
                'enabled' => false
            ],

            'xAxis' => [
                'categories' => $categories
            ],

            'yAxis' => [
                'title' => [
                    'text' => 'Qars'
                ]
            ],
            
            'series' => $qarSeries
        ]
    ]);
