<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Site */

$this->title = Yii::t('app', 'Create Site');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
