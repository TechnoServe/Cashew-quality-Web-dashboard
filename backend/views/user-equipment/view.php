<?php

use backend\models\Company;
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

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"> <?=Yii::t("app", "User Equipments details")?></h3>
    </div>

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
                    'attribute' => 'id_user',
                    'value' => $model->getUserFullName($model->id_user),
                ],
                [
                    'attribute' => 'company_id',
                    'value' => function($model){
                        $company = Company::findOne($model->company_id);
                        return $company ?  $company->name : null;
                    }
                ],
                'brand',
                'model',
                'name',
                [
                    'attribute' => 'picture',
                    'format'=>'raw',
                    'value' => function($model){
                        return Html::img($model->getThumbImagePath(),
                            ['width' => '60px']). "<br  />  " .  Html::a(Yii::t("app", "Click to expand"), [$model->getImagePath()], ["target"=>"_blank", "class"=>"btn-link"]);
                    }
                ],
                'manufacturing_date',
                'created_at',
            ],
        ]) ?>
    </div>

</div>