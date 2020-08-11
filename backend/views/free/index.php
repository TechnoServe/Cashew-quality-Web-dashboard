<?php

use backend\widgets\AnalyticsPeriodPicker;
use yii\helpers\Html;
use yii\web\JsExpression;

$this->title = Yii::t('app', 'Free version data');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel">

    <!--Panel heading-->
    <div class="panel-heading ">
        <h3 class="panel-title">
            <span class="text-1x text-muted text-bold text-italic"> <?=Yii::t("app", "Last synced")?> <?=$lastSync ? date("d M Y  H:i:s", strtotime($lastSync->value)) : Yii::t("app", "(Never)")?></span>
            <?= Html::a('<i class="pli-refresh icon-fw " style="font-size: 1.3em;"></i>'.Yii::t('app', 'Sync now'), ['free/pull-fire-store'],
                [
                    'class' => 'btn-link text-bold',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to pull current data ?'),
                        'method' => 'post',
                    ],
                ]
            ) ?>
        </h3>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="panel panel-info panel-colorful media middle pad-all">
                    <div class="media-left">
                        <div class="pad-hor">
                            <i class="pli-male icon-3x"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold pull-right">
                            <?= Html::a('<i class="pli-file-csv icon-fw " style="font-size: 1.3em;"></i>' .  Yii::t("app", "CSV"), ["free/export-users-csv"], ["class" => "btn btn-info btn-block"]) ?>
                        </p>
                        <p class="text-2x mar-no text-semibold"><?=number_format($freeUsers, null, null, ' ')?></p>
                        <p class="mar-no"><?=Yii::t("app", "Users")?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="panel panel-primary panel-colorful media middle pad-all">
                    <div class="media-left">
                        <div class="pad-hor">
                            <i class="pli-receipt-4 icon-3x"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold pull-right">
                            <?= Html::a('<i class="pli-file-csv icon-fw " style="font-size: 1.3em;"></i>' . Yii::t("app", "CSV"), ["free/export-qar-csv"], ["class" =>"btn btn-primary btn-block"]) ?>
                        </p>
                        <p class="text-2x mar-no text-semibold"><?=number_format($freeQar, null, null, ' ')?></p>
                        <p class="mar-no"><?=Yii::t("app", "QR(s)")?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="panel panel-mint panel-colorful media middle pad-all">
                    <div class="media-left">
                        <div class="pad-hor">
                            <i class="pli-map icon-3x"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold pull-right">
                            <?= Html::a( '<i class="pli-file-csv icon-fw " style="font-size: 1.3em;"></i>' .  Yii::t("app", "CSV"), ["free/export-sites-csv"], ["class" => "btn btn-mint btn-block"]) ?>
                        </p>
                        <p class="text-2x mar-no text-semibold"><?=number_format($freeSites, null, null, ' ')?></p>
                        <p class="mar-no"><?=Yii::t("app", "Sites")?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=AnalyticsPeriodPicker::widget(['startDate' => $startDate, 'endDate' => $endDate, 'predefinedPeriod' => $predefinedPeriod, 'url' => "free/index"])?>

<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title">
            <?=Yii::t("app", "QAR(s), Totals and Average KOR Graph against date period")?> <br>
        </h3>
    </div>
    <div class="panel-body">
        <p class="text-semibold text-uppercase text-main"><?=Yii::t("app", "Total QARs")?>: <?=number_format($totalQar, 0, 0, " ")?></p>
    </div>

    <div class="panel-body">
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
                'series' => $qarSeries
            ]
        ]);?>
    </div>
</div>


<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title">
            <?=Yii::t("app", "Top sites per average KOR in the selected period")?>
        </h3>
    </div>

    <div class="panel-body">
        <p class="text-semibold text-uppercase text-main"><?=Yii::t("app", "Total Sites")?>: <?=number_format($totalSites, 0, 0, " ")?></p>
    </div>

    <div class="panel-body">

        <div class="row">
            <div class="col-lg-6 bord-rgt">
                <p class="text-semibold text-uppercase text-main"><?=Yii::t("app", "Top sites by average KOR")?></p>
                <table class="table table-hover table-vcenter">
                    <thead>
                        <tr>
                            <th> <?=Yii::t("app", "Site Name")?></th>
                            <th class="text-center"><?=Yii::t("app", "Average KOR")?> <br> <small class="text-muted"><?=$startDate?> / <?=$endDate?></small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topSitesPerKor as $topSite): ?>
                        <tr>
                            <td>
                                <span class="text-main text-semibold"><?=$topSite["name"]?></span>
                                <br>
                                <i class="pli-location-2 icon-1x"></i>
                                <small class="text-muted"><?=$topSite["location"]?></small>
                            </td>
                            <td class="text-center"><span class="text-primary text-semibold"><?=number_format($topSite["average_kor"], 2, null, " ")?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-lg-6">
                <p class="text-semibold text-uppercase text-main"><?=Yii::t("app", "Top sites by number of QARs")?></p>
                <table class="table table-hover table-vcenter">
                    <thead>
                    <tr>
                        <th> <?=Yii::t("app", "Site Name")?></th>
                        <th class="text-center"><?=Yii::t("app", "Number of QARs")?> <br> <small class="text-muted"><?=$startDate?> / <?=$endDate?></small></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($topSitesPerQar as $topSite): ?>
                        <tr>
                            <td>
                                <span class="text-main text-semibold"><?=$topSite["name"]?></span>
                                <br>
                                <i class="pli-location-2 icon-1x"></i>
                                <small class="text-muted"><?=$topSite["location"]?></small>
                            </td>
                            <td class="text-center"><span class="text-primary text-semibold"><?=number_format($topSite["number_qar"], 0, null, " ")?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
</div>
</div>


<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title">
            <?=Yii::t("app", "Users growth against time")?>
        </h3>
    </div>

    <div class="panel-body">
        <p class="text-semibold text-uppercase text-main"><?=Yii::t("app", "Total users")?>: <?=number_format($totalUsers, 0, 0, " ")?></p>
    </div>

    <div class="panel-body">

        <?= \dosamigos\highcharts\HighCharts::widget([
            'clientOptions' => [
                'title' => [
                    'text' => false
                ],

                'credits' => [
                    'enabled' => false
                ],

                'xAxis' => [
                    'categories' => $categories,
                    'text' => false
                ],

                'exporting' => [
                    'filename' => 'free_version_users',
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

                'yAxis' => [
                    'labels' => [
                        'enabled' => true
                    ],
                    'title' => [
                        "text" => null
                    ]
                ],
                'series' => $userSeries
            ]
        ]);?>
    </div>
</div>
