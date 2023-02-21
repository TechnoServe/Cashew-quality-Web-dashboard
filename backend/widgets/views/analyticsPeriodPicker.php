<?php

use kartik\date\DatePicker;
use yii\helpers\Html; ?>

<div class="panel">
    <div class="panel-heading ">
        <h3 class="panel-title">
            <span class="text-1x text-muted text-bold text-italic"> <?=Yii::t("app", "Choose custom period")?></span>
        </h3>
    </div>
    <div class="panel-body">
        <form class="form-inline" action="<?=\yii\helpers\Url::to([$url])?>" method="get">
            <div class="form-group">
                <?= DatePicker::widget([
                    'name' => 'startDate',
                    'value' => date('Y-m-d', strtotime($startDate)),
                    'options' => ['placeholder' => Yii::t("app", "Period start")],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]);
                ?>
            </div>
            <div class="form-group">
                <?= DatePicker::widget([
                    'name' => 'endDate',
                    'value' => date('Y-m-d', strtotime($endDate)),
                    'options' => ['placeholder' => Yii::t("app", "Period end")],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]);
                ?>
            </div>
            <button class="btn btn-primary" type="submit"><?=Yii::t("app", "Confirm period")?></button>
        </form>

        <div class="pad-ver mar-btm">
            <div class="btn-group btn-group-justified">
                <?=Html::a(Yii::t("app", "This week"), [$url, "predefinedPeriod" => 1, "country_code" => $country_code], ["class"=>"btn " . ($predefinedPeriod == 1  ? "btn-default" : "btn-primary" ). " text-bold", "value"=>"one"])?>
                <?=Html::a(Yii::t("app", "This month"), [$url, "predefinedPeriod" => 2, "country_code" => $country_code], ["class"=>"btn " . ($predefinedPeriod == 2  ? "btn-default" : "btn-info" ). " text-bold", "value"=>"two"])?>
                <?=Html::a(Yii::t("app", "This quarter"), [$url, "predefinedPeriod" => 3, "country_code" => $country_code], ["class"=>"btn " . ($predefinedPeriod == 3  ? "btn-default" : "btn-warning" ). " text-bold", "value"=>"three"])?>
                <?=Html::a(Yii::t("app", "This year"), [$url, "predefinedPeriod" => 4, "country_code" => $country_code], ["class"=>"btn " . ($predefinedPeriod == 4  ? "btn-default" : "btn-mint" ). " text-bold", "value"=>"four"])?>
            </div>
        </div>
    </div>
</div>