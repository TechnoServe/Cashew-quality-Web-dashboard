<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

if (!$baseUrl):
    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token, 'requestOrigin' => $origin]);
else:
    $resetLink = $baseUrl . 'site/reset-password?token=' . $user->password_reset_token . "&requestOrigin=". $origin;
endif;
?>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app","Hello")?> <?= Html::encode($user->username) ?></p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", "You sent a request to reset your password")?></p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", "Follow the link below to set your new password:")?></p>
    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
        <tbody>
        <tr>
            <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                    <tbody>
                    <tr>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #294f75; border-radius: 5px; text-align: center;">
                            <a href="<?=$resetLink?>" target="_blank" style="display: inline-block; color: #ffffff; background-color: #294f75; border: solid 1px #294f75; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #294f75;"><?=Yii::t("app", "Reset Password")?></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", "If you think this notification is irrelevant, simply ignore it")?></p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?=Yii::t("app", "Cheers!")?> CNQA</p>
</td>
