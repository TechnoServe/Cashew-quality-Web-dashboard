<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
        <tr>
            <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                        <tr>
                            <td class="o_bg-dark o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-white" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;color: #000000;padding-left: 24px;padding-right: 24px;padding-top: 64px;padding-bottom: 64px;">
                                <h2 class="o_heading o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;font-size: 20px;line-height: 39px;">
                                    Hello <?= Html::encode($user->fullName) ?>,
                                </h2>
                                <p class="o_mb-md" style="margin-top: 24px;margin-bottom: 24px;">
                                    Here is your credentials:
                                    <br> Username: <b> <?= Html::encode($user->username) ?> </b>
                                    <br> Password: <b> <?= Html::encode($pass) ?> </b>
                                </p>
                                <p class="o_mb-md" style="margin-top: 0px;margin-bottom: 24px;">
                                    Follow the link below to verify your email:
                                </p>
                                <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                    <tbody>
                                        <tr>
                                            <td width="300" class="o_btn o_bg-primary o_br o_heading o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #126de5;border-radius: 4px;">
                                                <a class="o_text-white" href="<?= $verifyLink ?>" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;"><?= Yii::t("app", "Verify email") ?></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>