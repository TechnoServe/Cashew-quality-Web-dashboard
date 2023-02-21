<?php

use backend\models\Company;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Companies');
$this->params['breadcrumbs'][] = $this->title;
?>
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
            <?= Html::a('<i class="pli-file-csv icon-fw"></i>' .

                Yii::t('app', 'Export to CSV'),
                ['export-csv'],
                [
                    'data' => [
                        'method' => 'get',
                        'params' => [
                            'name' => $searchModel['name'],
                            'city' => $searchModel['city'],
                            'address' => $searchModel['address'],
                            'primary_contact' => $searchModel['primary_contact'],
                            'status' => $searchModel['status']
                        ],
                    ],
                    'class' => 'btn btn-mint'
                ]
            );
            ?>

            <?= Html::a('<i class="pli-file icon-fw"></i>' .Yii::t('app', 'Export to PDF'), ['export-pdf'], ['data' => [
                'method' => 'get',
                'params' => [
                    'name' => $searchModel['name'],
                    'city' => $searchModel['city'],
                    'address' => $searchModel['address'],
                    'primary_contact' => $searchModel['primary_contact'],
                    'status' => $searchModel['status']
                ],
            ],'class' => 'btn btn-warning']); ?>

            <?= Html::a('<i class="pli-add icon-fw"></i>' .Yii::t('app', 'Create Company'), ['create'], ['class' => 'btn btn-primary']) ?>

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
                        'attribute' => 'logo',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::img(
                                $model->getThumbLogoPath(),
                                ['width' => '50px']
                            );
                        }
                    ],
                    'name',
                    'city',
                    'address',
                    'primary_contact',
                    'fax_number',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return Company::getStatusDropdownValues()[$model->status];
                        },
                    ],
                    'created_at',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>

    </div>
</div>