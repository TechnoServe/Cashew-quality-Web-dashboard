<?php

use backend\models\Company;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Companies'),
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="panel">


    <div class="panel-body">

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app',
                            'Are you sure you want to delete this item?'),
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
                'name',
                'city',
                'address',
                'primary_contact',
                'primary_phone',
                'primary_email:email',
                'fax_number',
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        return Company::getStatusDropdownValues()[$model->status];
                    },
                ],
                [
                    'attribute' => 'logo',
                    'format'=>'raw',
                    'value' => function($model){
                        return Html::img($model->getThumbLogoPath(),
                                ['width' => '60px']). "<br  />  " .  Html::a(Yii::t("app", "Click to expand"), [$model->getLogoPath()], ["target"=>"_blank", "class"=>"btn-link"]);
                    }
                ],
                'description',
                'created_at',
                'updated_at',
            ],
        ]) ?>

    </div>

</div>
