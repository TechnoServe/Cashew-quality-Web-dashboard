<?php

use backend\models\Company;
use backend\models\User;
use common\helpers\CashewAppHtmlHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\QarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'created_at_start')->widget(DatePicker::className(), CashewAppHtmlHelper::getDatePickerWidgetValues("created_at_start", "date")) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'created_at_end')->widget(DatePicker::className(), CashewAppHtmlHelper::getDatePickerWidgetValues("created_at_end", "date")) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'buyer')->widget(Select2::className(), User::getUsersSelectWidgetValues('buyer', User::ROLE_FIELD_BUYER, "buyer_id",   Yii::t('app', 'All'))) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'field_tech')->widget(Select2::className(), User::getUsersSelectWidgetValues('field_tech', User::ROLE_FIELD_TECH, "field_tech_id",   Yii::t('app', 'All'))) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'initiator')->dropDownList(\backend\models\Qar::getInitiatorDropDownValues(), ["prompt" => Yii::t("app", "All")]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(\backend\models\Qar::getStatusDropDownValues(), ["prompt" => Yii::t("app", "All")]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'site_name') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'site_location') ?>
        </div>
    </div>

    <div class="row">
        <?php if (Yii::$app->user->identity->role == User::ROLE_ADMIN || Yii::$app->user->identity->role == User::ROLE_ADMIN_VIEW) : ?>
            <div class="col-md-6">
                <?= $form->field($model, 'company_id')->widget(Select2::className(), Company::getCompaniesSelectWidgetValues('company', "company_id",  Yii::t('app', 'All'))) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::button(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary form-reset-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>