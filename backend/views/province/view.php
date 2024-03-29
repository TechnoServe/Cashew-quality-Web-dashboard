<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t("app", 'Provinces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?= Yii::t("app", "Province details") ?></h3>
    </div>

    <div class="panel-body">

        <p>
            <?= Html::a(Yii::t("app", 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t("app", 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t("app", 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'country_code',
                'name',
                'postal_code',
                'created_at',
                'updated_at',
            ],
        ]) ?>

    </div>

</div>