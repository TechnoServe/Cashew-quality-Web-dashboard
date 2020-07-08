<?php

use backend\models\User;
use common\helpers\CashewAppHtmlHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserEquipment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-equipment-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_user')->widget(Select2::className(), User::getUsersSelectWidgetValues('id_user', User::ROLE_FIELD_TECH, "user_id",   Yii::t('app', 'Select Field Tech'))) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'brand')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'picture')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'manufacturing_date')->widget(DatePicker::className(), CashewAppHtmlHelper::getDatePickerWidgetValues("manufacturing_date", "date")) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>