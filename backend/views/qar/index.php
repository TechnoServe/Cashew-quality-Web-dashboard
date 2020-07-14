<?php

use backend\models\Company;
use backend\models\Qar;
use backend\models\Site;
use backend\models\User;
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
                [
                    'attribute' => 'buyer',
                    'value' => function ($model) {
                        $buyer = User::findOne($model->buyer);
                        if ($buyer) {
                            return $buyer->first_name." ".$buyer->middle_name." ".$buyer->last_name;
                        }

                        return null;
                    },
                ],
                [
                    'attribute' => 'field_tech',
                    'value' => function ($model) {
                        $field_tech = User::findOne($model->field_tech);
                        if ($field_tech) {
                            return $field_tech->first_name." ".$field_tech->middle_name." ".$field_tech->last_name;
                        }

                        return null;
                    },
                ],
                [
                    'attribute' => 'farmer',
                    'value' => function ($model) {
                        $farmer = User::findOne($model->farmer);
                        if ($farmer) {
                            return $farmer->first_name." ".$farmer->middle_name." ".$farmer->last_name;
                        }

                        return null;
                    },
                ],
                [
                    'attribute' => 'initiator',
                    'value' => function ($model) {
                        return Qar::getInitiatorByIndex($model->initiator);
                    },
                ],

                [
                    'attribute' => 'site',
                    'value' => function ($model) {
                        $site = Site::findOne($model->site);

                        return $site->site_name." ".$site->site_location;
                    },
                ],
                'audit_quantity',
                'created_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>

</div>
