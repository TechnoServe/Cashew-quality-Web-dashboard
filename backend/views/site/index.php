<?php

/* @var $this yii\web\View */

use backend\widgets\AnalyticsPeriodPicker;
use common\helpers\CashewAppHtmlHelper;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', ' Welcome to CashewNuts Application');
?>
<div class="site-index">

    <?= AnalyticsPeriodPicker::widget(['startDate' => $startDate, 'endDate' => $endDate, 'predefinedPeriod' => $predefinedPeriod, 'url' => "/"]) ?>

    <div class="panel">
        <div class="panel-heading bg-primary">
            <h4 class="panel-title"><?= Yii::t('app', 'QARs') ?></h4>
        </div>
        <div class="panel-body">
            <?= $this->render('//qar/_mini_stat', [
                'qarsInProgress' => $qarsInProgress,
                'qarsToBeDone' => $qarsToBeDone,
                'qarsCompleted' => $qarsCompleted,
                'qarsCanceled' => $qarsCanceled
            ]); ?>
        </div>

        <div class="panel-body">
            <?= $this->render('//qar/_mini_graph', [
                'qarsInProgress' => $qarsInProgress,
                'qarsToBeDone' => $qarsToBeDone,
                'qarsCompleted' => $qarsCompleted,
                'qarsCanceled' => $qarsCanceled,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'predefinedPeriod' => $predefinedPeriod,
                'categories' => $categories,
                'qarSeries' => $qarSeries
            ]) ?>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading bg-primary">
            <h4 class="panel-title"><?= Yii::t('app', 'Sites') ?></h4>
        </div>

        <div class="panel-body">
            <?= $this->render('//sites/_stat', [
                'totalSites' => $totalSites
            ]); ?>
        </div>

        <div class="panel-body">
            <h3 class="panel-title">
                <span class="text-1x text-muted text-bold text-italic"> <?= Yii::t("app", "Choose a Country") ?></span>
            </h3>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <form class="fomr-inline" method="get">
                            <div class="form-group">
                                <?= Select2::widget([
                                    'name' => 'country_code',
                                    'data' => CashewAppHtmlHelper::getCountriesSelectWidgetValues('country_code', "country_code", Yii::t('app', 'Select Country')),
                                    'options' => [
                                        'placeholder' => 'Select Country'
                                    ]
                                ])
                                ?>
                            </div>
                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <?= $this->render('//sites/_mini_heatmap', [
                'totalSites' => $totalSites,
                'categories' => $categories,
                'siteSeries' => $siteSeries,
                'country_code' => $country_code
            ]); ?>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading bg-primary">
            <h4 class="panel-title"><?= Yii::t('app', 'Users') ?></h4>
        </div>
        <div class="panel-body">
            <?= $this->render('//user/_mini_stat', [
                'totalUsers' => $totalUsers,
                'totalFieldTech' => $totalFieldTech,
                'totalBuyer' => $totalBuyer,
                'totalFarmer' => $totalFarmer
            ]); ?>
        </div>
    </div>
</div>