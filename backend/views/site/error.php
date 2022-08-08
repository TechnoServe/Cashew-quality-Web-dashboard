<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<!-- CONTENT -->
<!--===================================================-->
<div class="text-center cls-content" style="margin: 0 auto">
    <i style="font-size: 5em;" class="pli-exclamation text-danger" aria-hidden="true"></i>
    <p class="h4 text-uppercase text-bold"><?= nl2br(Html::encode($message)) ?></p>
    <div class="pad-btm">
        <p>
            <?= Yii::t("app", "The above error occurred while the Web server was processing your request.") ?>
            <br>
            <?= Yii::t("app", "Please contact your administrator if you think this is a server error. Thank you.") ?>
        </p>
    </div>
    <div class="pad-top">
        <?=Html::a(Yii::t("app", "Go back"), Yii::$app->request->referrer ?: Yii::$app->homeUrl, ["class"=>"btn btn-primary"])?>
    </div>
</div>
