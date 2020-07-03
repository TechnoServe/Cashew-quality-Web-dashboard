<?php

/* @var $this \yii\web\View */
/* @var $content string */

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
            <?=$content?>
        </div>
    </div>
    <!--===================================================-->





</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
