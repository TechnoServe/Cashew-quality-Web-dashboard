<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */

$this->title = 'Update Province: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t("app",'Provinces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?= Yii::t("app", "Province") ?> • <?= Yii::t("app", "Update form") ?></h3>
    </div>

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>