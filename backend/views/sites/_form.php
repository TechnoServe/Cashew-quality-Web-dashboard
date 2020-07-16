<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Site */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="site-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'site_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'map_location')->textInput(['maxlength' => true])->hint(Yii::t("app", "Enter the map location in the format: latitude,longitude"), ["class"=>"text-warning"]) ?>
        </div>
    </div>

    <?= $form->field($model, 'site_location')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'siteImage')->fileInput(['accept' => 'image/*'])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
