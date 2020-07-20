<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?=Yii::t("app", "User")?>  • <?=Yii::t("app", "Create form")?></h3>
    </div>

    <div class="panel-body">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
        
    </div>

</div>