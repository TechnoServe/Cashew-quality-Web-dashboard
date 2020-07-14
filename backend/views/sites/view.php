<?php

use backend\models\Company;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Site */

$this->title = $model->site_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="panel">

    <div class="panel-body">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id',
                'value' => function ($model) {
                    return "#".$model->id;
                },
            ],
            [
                'attribute' => 'company_id',
                'value' => function($model){
                    $company = Company::findOne($model->company_id);
                    return $company ?  $company->name : null;
                }
            ],
            'site_name',
            'site_location:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>


    </div>

</div>
