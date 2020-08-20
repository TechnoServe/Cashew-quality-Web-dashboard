<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Provinces');
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
            <?= Html::a('Create Province', ['create'], ['class' => 'btn btn-success']) ?>
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

                    //'id',
                    'country_code',
                    'name',
                    'postal_code',
                    'created_at',
                    //'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>