<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Qar */

$this->title = Yii::t('app', 'Create Qar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Qars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
