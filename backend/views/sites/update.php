<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Site */

$this->title = Yii::t('app', 'Update Site: {name}', [
    'name' => $model->site_name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->site_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?=Yii::t("app", "Site")?>  • <?=Yii::t("app", "Update form")?></h3>
    </div>

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
