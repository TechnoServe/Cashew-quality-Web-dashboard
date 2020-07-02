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
        <?php if(Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success" role="alert">
                <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
        <?php if(Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger" role="alert">
                <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        <div class="pad-btm mar-btm">
            <?= Html::img('@web/img/logo.png', ['alt' => 'TechnoServe Logo', 'class' => 'img-lg  ', 'style' => ['width' => 'auto']]) ?>
        </div>
        <div class="mar-ver pad-btm">
            <h3 class="h4 mar-no"><?= Yii::t('app','Account Login')?></h3>
            <!--                <p class="text-muted">--><?//= Yii::t('backend','Sign In to your account')?><!--</p>-->
        </div>

        <?php $form = ActiveForm::begin(['id' => 'staff-login-form','enableClientValidation'=>false]); ?>

        <div class="form-group">
            <?= $form->field($model, 'username', [
                'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent']
            ])->textInput()->input('text', ['placeholder' => Yii::t('app', 'Username')])->label(false); ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'password', [
                'inputOptions' => ['class' => 'form-control transparent']
            ])->passwordInput(['placeholder' => Yii::t('app','Password')])->label(false); ?>
        </div>

        <div class="checkbox pad-btm text-left">
            <?php /* echo $form->field($model, 'rememberMe', [
                    'inputOptions' => ['class' => 'magic-checkbox']
                ])->checkbox()*/ ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Login'), ['class' => 'btn btn-primary  btn-md btn-block', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>

        <div class="pad-all">

            <?php echo Html::a(Yii::t('app', 'Forgot password ?'), ['/site/request-password-reset'], [
                'class' => 'btn-link mar-center'])
            ?>
        </div>
    </div>
</div>
