<?php

use common\helpers\CashewAppHtmlHelper;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-3 col-sm-6">
        <a href="<?php echo Url::to(['/sites/index']) ?>">
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
        </a>
    </div>

    <div class="col-md-9 col-sm-6 col-xs-12">
        <form class="form-inline pull-right">
            <?php if ($predefinedPeriod) : ?>
                <input name="predefinedPeriod" type="hidden" value="<?= $predefinedPeriod ?>">
            <?php endif; ?>

            <?php if ($startDate) : ?>
                <input name="startDate" type="hidden" value="<?= $startDate ?>">
            <?php endif; ?>

            <?php if ($endDate) : ?>
                <input name="endDate" type="hidden" value="<?= $endDate ?>">
            <?php endif; ?>

            <input type="hidden">
            <input type="hidden">
            <div class="form-group" style="min-width: 200px;">
                <?= Select2::widget(CashewAppHtmlHelper::getCountriesSelectWidgetValues('country_code', "country_code", Yii::t('app', 'Select Country'), true, $country_code)) ?>
            </div>
            <?= Html::submitButton(Yii::t('app', 'OK'), ['class' => 'btn btn-primary']) ?>
        </form>
    </div>
</div>