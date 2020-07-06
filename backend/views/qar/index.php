<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\QarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Qars');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <div class="panel-body">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>


    <div class="panel-body">
        <p class="pull-right">
            <?= Html::a(Yii::t('app', 'Create Qar'), ['create'],
                ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <div class="panel-body">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'buyer',
                'field_tech',
                'farmer',
                'initiator',
                //'site',
                //'audit_quantity',
                //'created_at',
                //'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>

</div>
