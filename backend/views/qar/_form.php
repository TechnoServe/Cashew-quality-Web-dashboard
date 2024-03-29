<?php
use common\helpers\CashewAppHtmlHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;
/* @var $this yii\web\View */
/* @var $model backend\models\Qar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qar-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?php if ($showBuyerSelectorOnForm) : ?>
            <div class="col-md-6">
                <?= $form->field($model, 'buyer')->widget(Select2::className(), User::getUsersSelectWidgetValues('buyer', User::ROLE_FIELD_BUYER, "buyer_id",   Yii::t('app', 'Select Buyer'))) ?>
            </div>
        <?php endif; ?>

        <?php if ($showFieldTechSelectorOnForm) : ?>
            <div class="col-md-6">
                <?= $form->field($model, 'field_tech')->widget(Select2::className(), User::getUsersSelectWidgetValues('field_tech', User::ROLE_FIELD_TECH, "field_tech_id",   Yii::t('app', 'Select Field Tech'))) ?>
            </div>
        <?php endif; ?>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'initiator')->dropDownList(\backend\models\Qar::getInitiatorDropDownValues(), ["prompt" => Yii::t("app", "Select initiator")]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'deadline')->widget(DatePicker::className(), CashewAppHtmlHelper::getDatePickerWidgetValues("due_date", "date", null, null, date("Y-m-d", strtotime("now")), null)) ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'number_of_bags')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'volume_of_stock')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'site_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'site_location')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>