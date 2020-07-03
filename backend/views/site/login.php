<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="panel-body">

        <div class="pad-btm mar-btm">
            <?= Html::img('@web/img/logo.png', ['alt' => 'TechnoServe Logo', 'class' => 'img-lg', 'style' => ['width' => 'auto']]) ?>
        </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <p> <?= Yii::t("app", "Please fill out the following fields to login") ?></p>


            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            <?php
            $languageItems = new cetver\LanguageSelector\items\MenuLanguageItems([
                'languages' => [
                    'en' => '<span class="flag-icon flag-icon-us"></span> English',
                    'fr' => '<span class="flag-icon flag-icon-ru"></span> Français',
                    'pt' => '<span class="flag-icon flag-icon-de"></span> Português',
                ],
                'options' => ['encode' => false],
            ]);

            echo \yii\widgets\Menu::widget([
                'options' => ['class' => 'list-inline'],
                'items' => $languageItems->toArray(),
            ]);
            ?>

    </div>
</div>
