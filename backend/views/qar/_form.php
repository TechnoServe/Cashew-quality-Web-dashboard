<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Qar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'buyer')->textInput() ?>

    <?= $form->field($model, 'field_tech')->textInput() ?>

    <?= $form->field($model, 'farmer')->textInput() ?>

    <?= $form->field($model, 'initiator')->textInput() ?>

    <?= $form->field($model, 'site')->textInput() ?>

    <?= $form->field($model, 'audit_quantity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
