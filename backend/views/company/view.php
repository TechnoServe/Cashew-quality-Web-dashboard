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

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?= Yii::t("app", "Company details") ?></h3>
    </div>


    <div class="panel-body">

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']) ?>

            <?php if($model->status == Company::STATUS_ACTIVE): ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app',
                                'Are you sure you want to delete this company?'),
                            'method' => 'post',
                        ],
                    ]) ?>
            <?php endif; ?>

            <?php if($model->status == Company::STATUS_INACTIVE): ?>
                <?= Html::a(Yii::t('app', 'Re-activate'), ['restore', 'id' => $model->id],
                    [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => Yii::t('app',
                                'Are you sure you want to restore this company?'),
                            'method' => 'post',
                        ],
                    ]) ?>
            <?php endif; ?>
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
