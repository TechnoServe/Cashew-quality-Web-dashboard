<?php

/* @var $this yii\web\View */

use backend\widgets\AnalyticsPeriodPicker;

$this->title = Yii::t('app', ' Welcome to CashewNuts Application');
?>
<div class="site-index">

    <div class="panel">
        <div class="panel-heading">
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

        <?= AnalyticsPeriodPicker::widget(['startDate' => $startDate, 'endDate' => $endDate, 'predefinedPeriod' => $predefinedPeriod, 'url' => "/"]) ?>
        
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
                'series' => $series
            ]) ?>
        </div>
    </div>



    <div class="panel">
        <div class="panel-heading">
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