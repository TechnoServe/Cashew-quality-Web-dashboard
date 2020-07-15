<?php

use backend\models\Company;
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

        <div class="table-responsive" style="width: 100%">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-bordered table-striped table-vcenter'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'picture',
                        'format'=>'raw',
                        'value' => function($model){
                            return Html::img($model->getThumbImagePath(),
                                ['width' => '50px']);
                        }
                    ],

                    [
                        'attribute' => 'company_id',
                        'value' => function($model){
                            $company = Company::findOne($model->company_id);
                            return $company ?  $company->name : null;
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


</div>