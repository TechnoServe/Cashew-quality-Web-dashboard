<?php

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
            <?= $form->field($model, 'buyer') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'field_tech') ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'farmer') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'initiator') ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'site') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'audit_quantity') ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'created_at') ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'created_at') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
