<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t("app", "Reset password");
$this->params['breadcrumbs'][] = $this->title;
?>

<p class="pad-all"><?=Yii::t("app","Please choose your new password:")?> </p>

<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, "placeholder"=>Yii::t("app", "New Password")])->label(false) ?>

    <?= Html::submitButton(Yii::t("app", "Save password"), ['class' => 'btn btn-success btn-block']) ?>

<?php ActiveForm::end(); ?>

