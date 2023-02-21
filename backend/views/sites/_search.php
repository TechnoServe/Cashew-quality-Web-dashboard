<?php

use backend\models\Company;
use backend\models\User;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\SiteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

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
                <?= $form->field($model, 'company_id')->widget(Select2::className(), Company::getCompaniesSelectWidgetValues('company', "company_id",  Yii::t('app', 'Select Company'))) ?>
            </div>
        <?php endif; ?>
    </div>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::button(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary form-reset-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>