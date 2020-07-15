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

    <div class="panel-body">
        <?=$this->render('_search', ['model' => $searchModel]); ?>

    </div>

    <div class="panel-body">

        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Create Company'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <div class="table-responsive" style="width: 100%">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-bordered table-striped table-vcenter'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'logo',
                            'format'=>'raw',
                            'value' => function($model){
                                return Html::img($model->getThumbLogoPath(),
                                        ['width' => '50px']);
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
