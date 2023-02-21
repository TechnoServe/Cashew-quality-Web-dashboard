<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = Yii::t("app", 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>

    <p class="pad-all"><?=Yii::t("app","Enter your email address to recover your password.")?> </p>

    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true, "placeholder"=>Yii::t("app", "Email")])->label(false) ?>

        <?= Html::submitButton(Yii::t("app", "Reset Password"), ['class' => 'btn btn-danger btn-block']) ?>

    <?php ActiveForm::end(); ?>

    <div class="pad-top">
        <?=Html::a(Yii::t("app", "Back to login"), ["site/login"], ["class"=>"btn-link text-bold text-main"])?>
    </div>
