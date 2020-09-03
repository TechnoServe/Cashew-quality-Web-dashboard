<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Company */

$this->title = Yii::t('app', 'Create Company');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?= Yii::t("app", "Company") ?> • <?= Yii::t("app", "Create form") ?></h3>
    </div>


    <div class="panel-body">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div>

</div>
