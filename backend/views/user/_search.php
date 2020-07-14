<?php

use backend\models\Company;
use backend\models\User;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'username') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'first_name') ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <?= $form->field($model, 'last_name') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'role')->dropDownList(\backend\models\User::getUserRole(), ["prompt" => Yii::t('app', 'All')]) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(\backend\models\User::getUserStatus(), ["prompt" => Yii::t('app', 'All')]) ?>
        </div>

        <?php if (Yii::$app->user->identity->role == User::ROLE_ADMIN || Yii::$app->user->identity->role == User::ROLE_ADMIN_VIEW): ?>
        <div class="col-md-6">
            <?= $form->field($model, 'company_id')->widget(Select2::className(), Company::getCompaniesSelectWidgetValues('company',"company_id",  Yii::t('app', 'Select Company'))) ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app",'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t("app",'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>