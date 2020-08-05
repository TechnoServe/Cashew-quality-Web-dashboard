<?php

/* @var $this yii\web\View */

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
        <div class="panel-body">
            <?= $this->render('//qar/_mini_graph', [
                'qarsInProgress' => $qarsInProgress,
                'qarsToBeDone' => $qarsToBeDone,
                'qarsCompleted' => $qarsCompleted,
                'qarsCanceled' => $qarsCanceled
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