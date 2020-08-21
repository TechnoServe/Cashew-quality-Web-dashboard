<?php

use common\helpers\CashewAppHtmlHelper;
use kartik\select2\Select2;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="panel panel-mint panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-location-2 icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold"><?= number_format($totalSites, 0, 0, " ") ?></p>
                <p class="mar-no"> <?= Yii::t("app", "Total Sites") ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-9 col-sm-6 col-xs-12">
        <form class="form-inline pull-right">
            <div class="form-group" style="min-width: 200px;">
                <?= Select2::widget([
                    'name' => 'country_code',
                    'value' => $country_code,
                    'data' => CashewAppHtmlHelper::getCountriesSelectWidgetValues('country_code', "country_code", Yii::t('app', 'Select Country')),
                    'options' => [
                        'placeholder' => 'Select Country'
                    ]
                ])
                ?>
            </div>
            <?= Html::submitButton(Yii::t('app', 'OK'), ['class' => 'btn btn-primary']) ?>
        </form>
    </div>
</div>