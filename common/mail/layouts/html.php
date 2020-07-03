<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= Html::encode($this->title) ?></title>
    <style type="text/css">
        a { text-decoration: none; outline: none; }
        @media (max-width: 649px) {
            .o_col-full { max-width: 100% !important; }
            .o_col-half { max-width: 50% !important; }
            .o_hide-lg { display: inline-block !important; font-size: inherit !important; max-height: none !important; line-height: inherit !important; overflow: visible !important; width: auto !important; visibility: visible !important; }
            .o_hide-xs, .o_hide-xs.o_col_i { display: none !important; font-size: 0 !important; max-height: 0 !important; width: 0 !important; line-height: 0 !important; overflow: hidden !important; visibility: hidden !important; height: 0 !important; }
            .o_xs-center { text-align: center !important; }
            .o_xs-left { text-align: left !important; }
            .o_xs-right { text-align: left !important; }
            table.o_xs-left { margin-left: 0 !important; margin-right: auto !important; float: none !important; }
            table.o_xs-right { margin-left: auto !important; margin-right: 0 !important; float: none !important; }
            table.o_xs-center { margin-left: auto !important; margin-right: auto !important; float: none !important; }
            h1.o_heading { font-size: 32px !important; line-height: 41px !important; }
            h2.o_heading { font-size: 26px !important; line-height: 37px !important; }
            h3.o_heading { font-size: 20px !important; line-height: 30px !important; }
            .o_xs-py-md { padding-top: 24px !important; padding-bottom: 24px !important; }
            .o_xs-pt-xs { padding-top: 8px !important; }
            .o_xs-pb-xs { padding-bottom: 8px !important; }
        }
        @media screen {
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu7GxKOzY.woff2) format("woff2");
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; }
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 400;
                src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu4mxK.woff2) format("woff2");
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 700;
                src: local("Roboto Bold"), local("Roboto-Bold"), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmWUlfChc4EsA.woff2) format("woff2");
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; }
            @font-face {
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 700;
                src: local("Roboto Bold"), local("Roboto-Bold"), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmWUlfBBc4.woff2) format("woff2");
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
            .o_sans, .o_heading { font-family: "Roboto", sans-serif !important; }
            .o_heading, strong, b { font-weight: 700 !important; }
            a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; }
        }
    </style>
    <!--[if mso]>
    <style>
        table { border-collapse: collapse; }
        .o_col { float: left; }
    </style>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <?php $this->head() ?>
</head>
<body class="o_body o_bg-light" style="width: 100%;margin: 0px;padding: 0px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #dbe5ea;">
<?php $this->beginBody() ?>

<!-- preview-text -->
<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
    <tr>
        <td class="o_hide" align="center" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Email Summary (Hidden)</td>
    </tr>
    </tbody>
</table>
<!-- header -->
<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
    <tr>
        <td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="background-color: inherit;padding-left: 8px;padding-right: 8px;padding-top: 32px;">
            <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                <tbody>
                <tr>
                    <td class="o_bg-dark o_px o_py-md o_br-t o_sans o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: inherit;border-radius: 4px 4px 0px 0px;padding-left: 16px;padding-right: 16px;padding-top: 15px;padding-bottom: 0px;">
                        <p style="margin-top: 0px;margin-bottom: 0px;">
                            <a class="o_text-white" href="<?=Yii::$app->urlManager->createAbsoluteUrl(['site/index'])?>" style="text-decoration: none;outline: none;color: #000000;">
                                <h2 class="o_heading o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 30px;line-height: 39px;">CashewNuts App</h2></a>
                        </p>
                    </td>
                </tr>
                </tbody>
                </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
        </td>
    </tr>
    </tbody>
</table>

<?= $content ?>
<!-- footer -->
<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
    <tbody>
    <tr>
        <td class="o_bg-light o_px-xs o_pb-lg o_xs-pb-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-bottom: 32px;">
            <!--[if mso]><table width="632" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 632px;margin: 0 auto;">
                <tbody>
                <tr>
                    <td class="o_bg-dark o_px-md o_py-lg o_br-b o_sans o_text-xs o_text-dark_light" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;background-color:inherit;color: #a0a3ab;border-radius: 0px 0px 4px 4px;padding-left: 24px;padding-right: 24px;padding-top: 32px;padding-bottom: 32px;">
                        <p class="o_mb" style="margin-top: 0px;margin-bottom: 16px;">©<?= date('Y') ?> TechnoServe</p>
                        <p style="margin-top: 0px;margin-bottom: 0px;">
                            <a class="o_text-dark_light o_underline" href="https://www.technoserve.org/" style="text-decoration: underline;outline: none;color: #a0a3ab;">Website</a> <span class="o_hide-xs">&nbsp; • &nbsp;</span><br class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">
                            <a class="o_text-dark_light o_underline" href="https://twitter.com/TechnoServe" style="text-decoration: underline;outline: none;color: #a0a3ab;">Twitter</a> <span class="o_hide-xs">&nbsp; • &nbsp;</span><br class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">
                            <a class="o_text-dark_light o_underline" href="https://web.facebook.com/TechnoServe" style="text-decoration: underline;outline: none;color: #a0a3ab;">Facebook</a>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
            <div class="o_hide-xs" style="font-size: 64px; line-height: 64px; height: 64px;">&nbsp; </div>
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
