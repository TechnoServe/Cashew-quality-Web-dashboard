<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
        <tr>
            <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
                <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                    <tbody>
                        <tr>
                            <td class="o_bg-dark o_px-md o_py-xl o_xs-py-md o_sans o_text-md o_text-white" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;color: #000000;padding-left: 24px;padding-right: 24px;padding-top: 64px;padding-bottom: 64px;">

                                <p class="o_mb-md" style="margin-top: 0px;margin-bottom: 24px;">
                                    <?= Html::encode($body) ?>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>