<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserEquipment */

$this->title = 'Update User Equipment: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="panel">

    <div class="panel-body">

        <?= $this->render('_form', [
            'model' => $model,
            'showFieldTechSelectorOnForm' => $showFieldTechSelectorOnForm
        ]) ?>
        
    </div>

</div>