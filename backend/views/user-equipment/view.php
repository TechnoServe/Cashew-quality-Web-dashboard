<?php

use backend\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserEquipment */

$this->title = $model->getUserFullName($model->id_user);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Equipments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="panel">

    <div class="panel-body">

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'id_user',
                    'value' => $model->getUserFullName($model->id_user),
                ],
                'brand',
                'model',
                'name',
                'picture',
                // [
                //     'attribute' => 'picture',
                //     'value' => $model->picture,
                //     'format' => ['image', ['width'=>100, 'height'=>100]],
                // ],
                'manufacturing_date',
                'created_at',
            ],
        ]) ?>

    </div>

</div>