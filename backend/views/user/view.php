<?php

use backend\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                'username',
                'first_name',
                'middle_name',
                'last_name',
                'email:email',
                'phone',
                'address',
                [
                    'attribute' => Yii::t('app', 'Preferred Language'),
                    'value' => $model->getLanguageByIndex($model->language),
                ],
                [
                    'attribute' => Yii::t('app', 'Status'),
                    'value' => $model->getUserStatusByIndex($model->status),
                ],
                'created_at',
                [
                    'attribute' => Yii::t('app', 'Role'),
                    'value' => $model->getUserRoleByIndex($model->role),
                ],
            ],
        ]) ?>

    </div>

    <div class="panel-body">

        <h4>Equipments</h4>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'picture',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::img(
                            $model->getThumbImagePath(),
                            ['width' => '60px']
                        ) . "<br  />  " .  Html::a(Yii::t("app", "Click to expand"), [$model->getImagePath()], ["target" => "_blank", "class" => "btn-link"]);
                    }
                ],
                [
                    'attribute' => 'id_user',
                    'value' => function ($model) {
                        return $model->getUserFullName($model->id_user);
                    }
                ],
                'brand',
                'model',
                'name',
                'manufacturing_date',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>

</div>