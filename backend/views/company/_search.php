<?php

use backend\models\Company;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\CompanySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'city') ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'address') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'primary_contact') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(Company::getStatusDropdownValues(), ['prompt' => Yii::t("app", "All")]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::button(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary form-reset-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
