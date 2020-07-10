<?php

use backend\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserEquipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Equipments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <div class="panel-body">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <div class="panel-body">

        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Create User Equipment'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'picture',
                    'format'=>'raw',
                    'value' => function($model){
                        return Html::img($model->getThumbImagePath(),
                            ['width' => '50px']) . "<br  />  " .  Html::a(Yii::t("app", "Click to expand"), [$model->getImagePath()], ["target"=>"_blank", "class"=>"btn-link text-xs"]);
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