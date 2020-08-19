<?php

/* @var $this yii\web\View */

use backend\widgets\AnalyticsPeriodPicker;

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
            <?= $this->render('//sites/_mini_heatmap', [
                'totalSites' => $totalSites,
                'categories' => $categories,
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
    </div>
</div>