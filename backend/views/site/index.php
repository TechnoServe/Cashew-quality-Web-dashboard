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

    <?= AnalyticsPeriodPicker::widget(['startDate' => $startDate, 'endDate' => $endDate, 'predefinedPeriod' => $predefinedPeriod, 'country_code' => $country_code , 'url' => "/"]) ?>

    <div class="panel">
        <div class="panel-heading bg-primary">
            <h4 class="panel-title"><?= Yii::t('app', 'QARs') ?></h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $this->render('//qar/_mini_stat', [
                        'qarsInProgress' => $qarsInProgress,
                        'qarsToBeDone' => $qarsToBeDone,
                        'qarsCompleted' => $qarsCompleted,
                        'qarsCanceled' => $qarsCanceled
                    ]); ?>
                </div>
                <div class="col-md-8">
                    <?= $this->render('//qar/_mini_graph_pie', [
                        'qarsInProgress' => $qarsInProgress,
                        'qarsToBeDone' => $qarsToBeDone,
                        'qarsCompleted' => $qarsCompleted,
                        'qarsCanceled' => $qarsCanceled,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'predefinedPeriod' => $predefinedPeriod,
                        'categories' => $categories,
                        'qarSeries' => $qarSeries,
                        'qarPieSeries' => $qarPieSeries
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="col-md-12">
                <?= $this->render('//qar/_mini_graph', [
                    'qarsInProgress' => $qarsInProgress,
                    'qarsToBeDone' => $qarsToBeDone,
                    'qarsCompleted' => $qarsCompleted,
                    'qarsCanceled' => $qarsCanceled,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'predefinedPeriod' => $predefinedPeriod,
                    'categories' => $categories,
                    'qarSeries' => $qarSeries,
                    'qarPieSeries' => $qarPieSeries
                ]) ?>
            </div>

            <div class="col-md-3">

            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-heading bg-primary">
            <h4 class="panel-title"><?= Yii::t('app', 'Map for average KOR per country and province') ?></h4>
        </div>

        <div class="panel-body">
            <?= $this->render('//sites/_stat', [
                'totalSites' => $totalSites,
                'country_code' => $country_code,
                'predefinedPeriod' => $predefinedPeriod,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]); ?>
        </div>

        <div class="panel-body">
            <?= $this->render('//sites/_mini_heatmap', [
                'korLocations' => $korLocations,
                'country_code' => $country_code,
                'siteSeries' => $siteSeries
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
        <div class="panel-body">
            <?= $this->render('//user/_mini_graph', [
                'categories' => $categories,
                'userSeries' => $userSeries,
            ]); ?>
        </div>
    </div>
</div>