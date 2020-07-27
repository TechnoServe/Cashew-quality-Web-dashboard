<?php

use backend\models\Company;
use backend\models\Qar;
use backend\models\QarDetail;
use backend\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Qar */

$this->title = Yii::t("app", "QAR")."#".$model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Qars'),
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">

    <div class="panel-heading bg-primary">

        <h3 class="panel-title">

            <?= Yii::t("app", "QAR")."#".$model->id . " " .Yii::t("app", "Request Details")?>

            &nbsp;

            <?php if($model->status == Qar::STATUS_TOBE_DONE): ?>
            <span class="badge badge-warning"> <?=Qar::getStatusDropDownValues()[$model->status]?> </span>
            <?php endif;  ?>

            <?php if($model->status == Qar::STATUS_IN_PROGRESS): ?>
                <span class="badge badge-info"> <?=Qar::getStatusDropDownValues()[$model->status]?> </span>
            <?php endif;  ?>


            <?php if($model->status == Qar::STATUS_COMPLETED): ?>
                <span class="badge badge-mint"> <?=Qar::getStatusDropDownValues()[$model->status]?> </span>
            <?php endif;  ?>


            <?php if($model->status == Qar::STATUS_CANCELED): ?>
                <span class="badge badge-danger"> <?=Qar::getStatusDropDownValues()[$model->status]?> </span>
            <?php endif;  ?>

        </h3>
    </div>

    <div class="panel-body">

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app',
                            'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
        </p>

        <div class="row">
            <div class="col-md-6">

            </div>
        </div>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'id',
                    'value' => function ($model) {
                        return "#".$model->id;
                    },
                ],
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

                'number_of_bags',
                'volume_of_stock',
                'deadline',
                'created_at',
                'updated_at',
            ],
        ]) ?>
    </div>

    <div class="panel-heading">
        <h3 class="panel-title">
            <?php $site = \backend\models\Site::findOne($model->site)?>
            <?=Html::a(Yii::t("app", "Site details"), ["sites/view", "id"=>$site->id], ["class"=>'btn-link'])?>
        </h3>
    </div>

    <div class="panel-body">
        <?= $this->render('../sites/_view_site', ['model' => $site]); ?>
    </div>

</div>


<?php if($model->status != Qar::STATUS_TOBE_DONE): ?>

 <?php foreach ($measurements as $key=>$measurement): ?>
        <?= $this->render('_qar_measurements', ['measurement' => $measurement, 'key'=>$key, 'model'=>$model]); ?>
    <?php endforeach; ?>
<?php endif; ?>
