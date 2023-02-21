<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserEquipment */

$this->title = Yii::t('app', 'Create User Equipment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Equipments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?=Yii::t("app", "Equipment")?>  • <?=Yii::t("app", "Create form")?></h3>
    </div>

    <div class="panel-body">

        <?= $this->render('_form', [
            'model' => $model,
            'showFieldTechSelectorOnForm'=>$showFieldTechSelectorOnForm
        ]) ?>

    </div>

</div>