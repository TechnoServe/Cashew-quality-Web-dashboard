<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t("app", "Login");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
     <p> <?= Yii::t("app", "Please fill out the following fields to login") ?></p>


    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, "placeholder"=>Yii::t("app", "Username")])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(["placeholder"=>Yii::t("app", "password")])->label(false) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t("app", "Login"), ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="pad-all">
        <?=Html::a(Yii::t("app", "Forgot your password ?"), ["site/request-password-reset"], ["class"=>"btn-link mar-rgt"])?>
    </div>
</div>
