<?php

use backend\models\Company;
use backend\models\User;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\UserEquipmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-equipment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_user')->widget(Select2::className(), User::getUsersSelectWidgetValues('field_tech', User::ROLE_FIELD_TECH, "field_tech_id",   Yii::t('app', 'All'))) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'brand') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'model') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
        </div>
    </div>

    <?php if (Yii::$app->user->identity->role == User::ROLE_ADMIN || Yii::$app->user->identity->role == User::ROLE_ADMIN_VIEW): ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'company_id')->widget(Select2::className(), Company::getCompaniesSelectWidgetValues('company',"company_id",  Yii::t('app', 'Select Company'))) ?>
        </div>
    </div>
    <?php endif;  ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app",'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::button(Yii::t("app",'Reset'), ['class' => 'btn btn-outline-secondary form-reset-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>