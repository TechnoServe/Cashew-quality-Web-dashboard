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
<div class="panel">

    <div class="panel-body">
        <?= $this->render('_search', ['model' => $searchModel]); ?>

    </div>

    <div class="panel-body">
        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Create Site'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'company_id',
                    'value' => function($model){
                        $company = Company::findOne($model->company_id);
                        return $company ?  $company->name : null;
                    }
                ],
                'site_name',
                'site_location:ntext',
                'created_at',
                'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
