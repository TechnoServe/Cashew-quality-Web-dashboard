<?php

use backend\models\Company;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\SiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sites');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render(
    '_mini_stat',
    [
        'totalSites' => $totalSites,
        'totalSitesWithoutImages' => $totalSitesWithoutImages,
        'totalSitesWithoutSiteLocation' => $totalSitesWithoutSiteLocation,
    ]
); ?>

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
            <?= Html::a( '<i class="pli-file-csv icon-fw"></i>' .
                Yii::t('app', 'Export to CSV'),
                ['export-csv'],
                [
                    'data' => [
                        'method' => 'get',
                        'params' => [
                            'site_name' => $searchModel['site_name'],
                            'site_location' => $searchModel['site_location'],
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
                    'site_name' => $searchModel['site_name'],
                    'site_location' => $searchModel['site_location'],
                    'company_id' => $searchModel['company_id']
                ],
            ], 'class' => 'btn btn-warning']); ?>

            <?= Html::a('<i class="pli-add icon-fw"></i>' . Yii::t('app', 'Create Site'), ['create'], ['class' => 'btn btn-primary']) ?>

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
                    [
                        'attribute' => 'image',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::img(
                                $model->getThumbImagePath(),
                                ['width' => '50px']
                            );
                        }
                    ],
                    'site_name',
                    'site_location:ntext',
                    'map_location',
                    'created_at',
                    'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>