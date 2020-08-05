<?php

use backend\widgets\AnalyticsPeriodPicker;
use yii\helpers\Html;

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
