<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app","Hello", [], $locale)?> <?= Html::encode($recipient["username"]) ?></p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><strong><?= $body ?></strong></p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", "Cheers!", [], $locale)?> CNQA</p>
</td>