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
     <div class="panel">

        <h3 class="panel-title bg-primary">
                <?= Yii::t("app", "QAR")."#".$model->id . " " .Yii::t("app", "Measurements")?> • <?=Yii::t("app", "Sample")." #". $key ?>
        </h3>
            <div class="panel-body">
            <div class="row">
                <div class="col-md-4 col-sm-6" style="background: #ecf0f5">

                    <h4 class="text-main"><?=Yii::t("app", "QAE Result")?></h4>
                    <table class="table table-vcenter" style="width: auto">
                        <tbody>
                        <tr>
                            <td>
                                <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_KOR]?></span>
                                <br>
                                <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_KOR, $measurement)['updated_at']?></small>
                            </td>
                            <td class="text-center"><span class="text-primary text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_KOR, $measurement)['value']?></span></td>
                        </tr>
                        <tr>
                            <?php $value = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_DEFECTIVE_RATE, $measurement)['value']; ?>
                            <td width="40%">
                                <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_DEFECTIVE_RATE]?></span>
                                <br>
                                <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_DEFECTIVE_RATE, $measurement)['updated_at']?></small>
                            </td>
                            <td width="30%" class="text-center">
                                <span class="text-danger text-semibold"><?=$value?>%</span>

                            </td>
                        </tr>
                        <tr>
                            <?php $value = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_DEFECTIVE_RATE, $measurement)['value']; ?>

                            <td>
                                <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_FOREIGN_MATERIAL_RATE]?></span>
                                <br>
                                <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_FOREIGN_MATERIAL_RATE, $measurement)['updated_at']?></small>
                            </td>
                            <td class="text-center"><span class="text-warning text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_FOREIGN_MATERIAL_RATE, $measurement)['value']?>%</span></td>
                        </tr>
                        <tr>
                            <td>
                                <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_MOISTURE_CONTENT]?></span>
                                <br>
                                <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_MOISTURE_CONTENT, $measurement)['updated_at']?></small>
                            </td>
                            <td class="text-center"><span class="text-warning text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_MOISTURE_CONTENT, $measurement)['value']?>%</span></td>
                        </tr>
                        <tr>
                            <td>
                                <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_NUT_COUNT]?></span>
                                <br>
                                <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_NUT_COUNT, $measurement)['updated_at']?></small>
                            </td>
                            <td class="text-center"><span class="text-primary text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_NUT_COUNT, $measurement)['value']?></span></td>
                        </tr>
                        <tr>
                            <td>
                                <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_USEFUL_KERNEL]?></span>
                                <br>
                                <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_USEFUL_KERNEL, $measurement)['updated_at']?></small>
                            </td>
                            <td class="text-center"><span class="text-success text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_USEFUL_KERNEL, $measurement)['value']?>g</span></td>
                        </tr>
                        <tr>
                            <td>
                                <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_VOLUME_TOTAL_STOCK]?></span>
                                <br>
                                <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_VOLUME_TOTAL_STOCK, $measurement)['updated_at']?></small>
                            </td>
                            <td class="text-center"><span class="text-primary text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_VOLUME_TOTAL_STOCK, $measurement)['value']?>g</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-8 col-sm-12">
                    <h4 class="text-main"><?=Yii::t("app", "QAE Measurement details")?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <table class="table table-vcenter" style="width: auto">
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_NUMBER_OF_BAGS_SAMPLED]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_NUMBER_OF_BAGS_SAMPLED, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-primary text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_NUMBER_OF_BAGS_SAMPLED, $measurement)['value']?></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_TOTAL_NUMBER_OF_BAGS]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_TOTAL_NUMBER_OF_BAGS, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-primary text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_TOTAL_NUMBER_OF_BAGS, $measurement)['value']?></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_NUT_WEIGHT]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_NUT_WEIGHT, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-primary text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_NUT_WEIGHT, $measurement)['value']?>g</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_NUT_COUNT]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_NUT_COUNT, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-primary text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_NUT_COUNT, $measurement)['value']?></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_MOISTURE_CONTENT]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_MOISTURE_CONTENT, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-warning text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_MOISTURE_CONTENT, $measurement)['value']?>%</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_FOREIGN_MATERIAL]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_FOREIGN_MATERIAL, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-danger text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_FOREIGN_MATERIAL, $measurement)['value']?>g</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <table class="table table-vcenter" style="width: auto">
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_GOOD_KERNEL]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_GOOD_KERNEL, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-success text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_GOOD_KERNEL, $measurement)['value']?>g</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_SPOTTED_KERNEL]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_SPOTTED_KERNEL, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-warning text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_SPOTTED_KERNEL, $measurement)['value']?>g</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_IMMATURE_KERNEL]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_IMMATURE_KERNEL, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-warning text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_IMMATURE_KERNEL, $measurement)['value']?>g</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_OILY_KERNEL]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_OILY_KERNEL, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-warning text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_OILY_KERNEL, $measurement)['value']?>g</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_BAD_KERNEL]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_BAD_KERNEL, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-danger text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_BAD_KERNEL, $measurement)['value']?>g</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_VOID_KERNEL]?></span>
                                        <br>
                                        <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_VOID_KERNEL, $measurement)['updated_at']?></small>
                                    </td>
                                    <td class="text-center"><span class="text-danger text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_VOID_KERNEL, $measurement)['value']?>g</span></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
 <?php endforeach; ?>
<?php endif; ?>
