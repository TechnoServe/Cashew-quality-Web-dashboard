<?php

use backend\models\Company;
use backend\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('//user/_mini_stat', [
    'totalUsers' => $totalUsers,
    'totalFieldTech' => $totalFieldTech,
    'totalBuyer' => $totalBuyer
]); ?>

<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?= Yii::t("app", "Search form") ?></h3>
    </div>

    <div class="panel-body">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <hr>

    <div class="panel-heading">
        <p class="pull-right pad-all">
            <?= Html::a(
                '<i class="pli-file-csv icon-fw"></i>' .
                    Yii::t('app', 'Export to CSV'),
                ['export-csv'],
                [
                    'data' => [
                        'method' => 'get',
                        'params' => [
                            'username' => $searchModel['username'],
                            'first_name' => $searchModel['first_name'],
                            'last_name' => $searchModel['last_name'],
                            'role' => $searchModel['role'],
                            'status' => $searchModel['status'],
                            'company_id' => $searchModel['company_id']
                        ],
                    ],
                    'class' => 'btn btn-mint'
                ]
            );
            ?>

            <?= Html::a('<i class="pli-file icon-fw"></i>' . Yii::t('app', 'Export to PDF'), ['export-pdf'], ['data' => [
                'method' => 'get',
                'params' => [
                    'username' => $searchModel['username'],
                    'first_name' => $searchModel['first_name'],
                    'last_name' => $searchModel['last_name'],
                    'role' => $searchModel['role'],
                    'status' => $searchModel['status'],
                    'company_id' => $searchModel['company_id']
                ],
            ], 'class' => 'btn btn-warning']); ?>

            <?= Html::a('<i class="pli-add icon-fw"></i>' . Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-primary']) ?>


        </p>
        <h3 class="panel-title"><?= Yii::t("app", "Search results") ?></h3>
    </div>

    <div class="panel-body">

        <div class="table-responsive" style="width: 100%">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-bordered table-striped table-vcenter'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'company_id',
                        'value' => function ($model) {
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
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return User::getUserStatusByIndex($model->status);
                        }
                    ],
                    [
                        'attribute' => 'role',
                        'value' => function ($model) {
                            return User::getUserRole()[$model->role];
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                    ],
                ],
            ]); ?>
        </div>

    </div>

</div>