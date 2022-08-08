<?php

use backend\models\Company;
use yii\grid\GridView;
use yii\helpers\Html;
!isset($summary) ? $summary = true : null;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => $summary ?  "{summary}\n{items}\n{pager}" : "{items}\n{pager}",
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