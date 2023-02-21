<?php

use yii\helpers\Html;
$this->title = "Result";
$this->params["hideLanguageSelector"] = true;
?>

<div class="text-bold alert alert-<?=$type?>">
    <?=$message?>
</div>

<?php if(isset($loginLink) && $loginLink): ?>
    <div class="pad-top">
        <?=Html::a(Yii::t("app", "Go to login screen"), ["site/login"], ["class"=>"btn-link text-bold text-main"])?>
    </div>
<?php endif; ?>
