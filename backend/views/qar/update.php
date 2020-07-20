<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Qar */

$this->title = Yii::t('app', 'Update Qar: {name}', [
    'name' => "#". $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Qars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>  "#" . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="panel">
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'showFieldTechSelectorOnForm' => $showFieldTechSelectorOnForm,
            'showBuyerSelectorOnForm' => $showBuyerSelectorOnForm,
            'showFarmerSelectorOnForm' => $showFarmerSelectorOnForm,
        ]) ?>
    </div>
</div>
