<?php

use backend\models\Company;
use backend\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <div class="panel-body">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <div class="panel-body">

        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="table-responsive" style="width: 100%">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-bordered table-striped table-vcenter'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'company_id',
                        'value' => function($model){
                            $company = Company::findOne($model->company_id);
                            return $company ?  $company->name : null;
                        }
                    ],
                    'username',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'address',
                    [
                        'attribute' => Yii::t('app', 'Status'),
                        'value' => function ($model) {
                            return User::getUserStatusByIndex($model->status);
                        }
                    ],
                    [
                        'attribute' => Yii::t('app', 'Role'),
                        'value' => function ($model) {
                            return User::getUserRole()[$model->role];
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>

    </div>

</div>