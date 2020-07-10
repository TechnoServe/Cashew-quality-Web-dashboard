<?php

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

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app",'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t("app",'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>