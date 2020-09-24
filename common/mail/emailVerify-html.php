<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token, 'requestOrigin' => $origin]);
?>

<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app","Hello", [], $user->language)?> <?= Html::encode($user->fullName) ?></p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", " Welcome to CashewNuts Application", [], $user->language)?></p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", "Here are your credentials", [], $user->language)?>:</p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">
        <?=Yii::t("app", "Username")?>: <strong><?=Html::encode($user->username)?></strong>
        <br>
       <?=Yii::t("app", "Password")?>:  <strong><?=Html::encode($pass)?></strong>
    </p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", "Please follow the link below to verify your email", [], $user->language)?> :</p>

    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
        <tbody>
        <tr>
            <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                    <tbody>
                    <tr>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #294f75; border-radius: 5px; text-align: center;">
                            <a href="<?= $verifyLink ?>" target="_blank" style="display: inline-block; color: #ffffff; background-color: #294f75; border: solid 1px #294f75; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #294f75;"><?=Yii::t("app", "Verify email", [], $user->language)?></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", "If you think this notification is irrelevant, simply ignore it", [], $user->language)?></p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", "Cheers!", [], $user->language)?> CNQA</p>
</td>