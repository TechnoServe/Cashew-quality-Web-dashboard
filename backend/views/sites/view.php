<?php

use backend\models\Company;
use backend\widgets\AnalyticsPeriodPicker;
use voime\GoogleMaps\Map;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\DetailView;
use yii2mod\google\maps\markers\GoogleMaps;

/* @var $this yii\web\View */
/* @var $model backend\models\Site */



$this->title = $model->site_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?=$this->registerCss("
#map img
    {
        max-width: none;
    }")?>


<div class="panel-body demo-nifty-btn">
    <a href="#qarDetails" class="btn btn-default btn-rounded js-scroll-trigger"><?=Yii::t("app", "Site Details")?></a>
    <a href="#latestQars" class="btn btn-primary btn-rounded js-scroll-trigger"><?=Yii::t("app", "Latest QAR(s) on this site")?></a>
    <a href="#averageKOR" class="btn btn-info btn-rounded js-scroll-trigger"><?=Yii::t("app", "Average KOR")?></a>
</div>

<div class="panel" id="qarDetails">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?=Yii::t("app", "Site Details")?></h3>
    </div>
    <div class="panel-body">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= $this->render('_view_site', ['model' => $model]);?>

        <?php if(!empty($model->map_location)): ?>
    <div id="map">

        <?= Map::widget([
            'zoom' => 15,
            'center' => [(double)$model->latitude, (double)$model->longitude],
            'markers' => [
                ['position' => [(double)$model->latitude, (double)$model->longitude]],
            ],
            'height' => '400px',
            'mapType' => Map::MAP_TYPE_HYBRID,
        ]);
        ?>
    </div>

        <?php endif; ?>
    </div>
</div>

<div class="panel" id="latestQars">

    <div class="panel-heading bg-primary">

        <h3 class="panel-title">
            <?=Html::a(Yii::t("app", "Latest QAR(s) on this site"), ["qar/index", "site"=>$model->id], ["class"=>'btn-link'])?>
        </h3>
    </div>

    <div class="panel-body">
        <?= $this->render('../qar/_grid_view', ['dataProvider' => $qarListDataProvider, 'summary' => false]); ?>
    </div>

</div>



<div class="panel" id="averageKOR">
    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?=Yii::t("app", "Average KOR")?></h3>
    </div>

    <div class="panel-body">
        <?=AnalyticsPeriodPicker::widget(['startDate' => $startDate, 'endDate' => $endDate, 'predefinedPeriod' => $predefinedPeriod, 'url' => "sites/view/".$model->id])?>
        <?= \dosamigos\highcharts\HighCharts::widget([
            'clientOptions' => [
                'title' => [
                    'text' => false
                ],

                'credits' => [
                    'enabled' => false
                ],

                'chart' => [
                    'type' => 'Combination chart'
                ],

                'exporting' => [
                    'filename' => 'free_version_qars',
                    'buttons' => [
                        'contextButton' => [
                            'menuItems' => [
                                [
                                    'textKey' => 'printChart',
                                    'text' => '<span style="font-size: 1.2em;"><i class="pli-printer"></i> ' . Yii::t("app", "Print Chart") . "</span>",
                                    'onclick' => new JsExpression("function () {this.print();}")
                                ],
                                [
                                    'textKey' => 'downloadPNG',
                                    'text' => '<span style="font-size: 1.2em;"><i class="pli-file-jpg"></i> ' . Yii::t("app", "Download PNG Image") . "</span>",
                                    'onclick' => new JsExpression("function () {this.exportChart();}")
                                ],
                                [
                                    'textKey' => 'downloadPNG',
                                    'text' => '<span style="font-size: 1.2em;"> <i class="pli-file-text-image"></i> ' . Yii::t("app", "Download PDF Document") . "</span>",
                                    'onclick' => new JsExpression("function () {this.exportChart({type: 'application/pdf'});}")
                                ],
                            ],
                        ]

                    ],
                ],

                'xAxis' => [
                    'categories' => $categories,
                    'text' => false
                ],

                'yAxis' => [
                    'labels' => [
                        'enabled' => true
                    ],
                    'title' => [
                        "text" => null
                    ]
                ],
                'series' => $chartSeries
            ]
        ]);?>

    </div>
</div>



