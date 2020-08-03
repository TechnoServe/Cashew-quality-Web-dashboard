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

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?= Yii::t("app", "Search form") ?></h3>
    </div>

    <div class="panel-body">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>


    <div class="panel-heading">
        <p class="pull-right pad-all">
            <?= Html::a( '<i class="pli-file-csv icon-fw"></i>' .
                Yii::t('app', 'Export to CSV'),
                ['export-csv'],
                [
                    'data' => [
                        'method' => 'post',
                        'params' => [
                            'id_user' => $searchModel['id_user'],
                            'brand' => $searchModel['brand'],
                            'model' => $searchModel['model'],
                            'name' => $searchModel['name']
                        ],
                    ],
                    'class' => 'btn btn-mint'
                ]
            );
            ?>

            <?= Html::a('<i class="pli-file icon-fw"></i>' .Yii::t('app', 'Export to PDF'), ['export-pdf'], ['class' => 'btn btn-warning']); ?>

            <?= Html::a('<i class="pli-add icon-fw"></i>' .Yii::t('app', 'Create User Equipment'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <h3 class="panel-title"><?= Yii::t("app", "Search results") ?></h3>
    </div>

    <div class="panel-body">
        <div class="table-responsive" style="width: 100%">
            <?= $this->render('_grid_view', ['dataProvider' => $dataProvider]); ?>
        </div>
    </div>
</div>