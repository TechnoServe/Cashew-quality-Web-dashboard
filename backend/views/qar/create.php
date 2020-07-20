<?php

use backend\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Qar */

$this->title = Yii::t('app', 'Create Qar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Qars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
