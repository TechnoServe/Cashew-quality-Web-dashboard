<?php

/* @var $this \yii\web\View */
/* @var $content string */

use cetver\LanguageSelector\items\MenuLanguageItems;
use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="container" class="cls-container">

    <!-- BACKGROUND IMAGE -->
    <!--===================================================-->
    <div id="bg-overlay"></div>


    <!-- LOGIN FORM -->
    <!--===================================================-->
    <div class="cls-content">
        <div class="cls-content-sm panel">

            <div class="panel-body">

                <a href="<?=Yii::$app->homeUrl?>">
                    <div class="pad-btm mar-btm">
                        <?= Html::img('@web/img/logo.png', ['alt' => 'TechnoServe Logo', 'class' => 'img-lg', 'style' => ['width' => 'auto']]) ?>
                    </div>
                </a>

                <?php

                // display all flash messages kept into the current user's session
                $flashMessages = Yii::$app->session->getAllFlashes();

                if ($flashMessages) {
                    echo '<div class="flashes text-center" style="list-style-type: none;">';
                    foreach ($flashMessages as $key => $message) {
                        echo '<p class="alert alert-' . $key . '">' . $message . " </p>";
                    }
                    echo '</div>';
                }
                ?>

                <?=$content?>

                <div class="language-selector" style="font-weight: bold; margin-top: 20px;">
                    <?php
                    $languageItems = new cetver\LanguageSelector\items\MenuLanguageItems([
                        'languages' => [
                            'en' => '<i class="pli-globe"></i> English',
                            'fr' => '<i class="pli-globe"></i> Français',
                            'pt' => '<i class="pli-globe"></i> Português',
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
        </div>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
