<?php
use backend\models\Qar;
use backend\models\QarDetail;
?>

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
                    <!--KOR-->
                    <?php
                    $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_KOR, $measurement);
                    if(!empty($data)): ?>
                    <tr>

                        <td>
                            <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_KOR]?></span>
                            <br>
                            <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                        </td>
                        <td class="text-center"><span class="text-primary text-semibold"><?=$data['value']?></span></td>
                    </tr>
                    <?php endif; ?>

                    <!--DEFECTIVE RATE-->
                    <?php
                    $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_DEFECTIVE_RATE, $measurement);
                    if(!empty($data)): ?>
                    <tr>
                        <td width="40%">
                            <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_DEFECTIVE_RATE]?></span>
                            <br>
                            <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                        </td>
                        <td width="30%" class="text-center">
                            <span class="text-danger text-semibold"><?=$data['value']?>%</span>

                        </td>
                    </tr>
                    <?php endif; ?>


                    <!--DEFECTIVE RATE-->
                    <?php
                    $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_FOREIGN_MATERIAL_RATE, $measurement);
                    if(!empty($data)): ?>
                    <tr>
                        <td>
                            <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_FOREIGN_MATERIAL_RATE]?></span>
                            <br>
                            <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                        </td>
                        <td class="text-center"><span class="text-warning text-semibold"><?=$data['value']?>%</span></td>
                    </tr>
                    <?php endif; ?>

                    <!--RESULT MOISTURE CONTENT-->
                    <?php
                    $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_MOISTURE_CONTENT, $measurement);
                    if(!empty($data)): ?>
                    <tr>
                        <td>
                            <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_MOISTURE_CONTENT]?></span>
                            <br>
                            <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                        </td>
                        <td class="text-center"><span class="text-warning text-semibold"><?=$data['value']?>%</span></td>
                    </tr>
                    <?php endif; ?>


                    <!--RESULT NUT COUNT-->
                    <?php
                    $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_NUT_COUNT, $measurement);
                    if(!empty($data)): ?>
                    <tr>
                        <td>
                            <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_NUT_COUNT]?></span>
                            <br>
                            <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                        </td>
                        <td class="text-center"><span class="text-primary text-semibold"><?=$data['value']?></span></td>
                    </tr>
                    <?php endif; ?>

                    <!--USEFUL KERNEL-->
                    <?php
                    $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::RESULT_USEFUL_KERNEL, $measurement);
                    if(!empty($data)): ?>
                    <tr>
                        <td>
                            <span class="text-main text-semibold"><?=Qar::qarResultLabels()[Qar::RESULT_USEFUL_KERNEL]?></span>
                            <br>
                            <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                        </td>
                        <td class="text-center"><span class="text-success text-semibold"><?=$data['value']?>g</span></td>
                    </tr>
                    <?php endif; ?>

                    <!--VOLUME TOTAL STOCK-->
                    <?php
                    $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_VOLUME_TOTAL_STOCK, $measurement);
                    if(!empty($data)): ?>
                    <tr>
                        <td>
                            <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_VOLUME_TOTAL_STOCK]?></span>
                            <br>
                            <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                        </td>
                        <td class="text-center"><span class="text-primary text-semibold"><?=$data['value']?>g</span></td>
                    </tr>
                    <?php endif; ?>
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
                            <!--NUMBER OF BAGS-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_NUMBER_OF_BAGS_SAMPLED, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_NUMBER_OF_BAGS_SAMPLED]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center">
                                    <span class="text-primary text-semibold"><?=$data['value']?></span>
                                </td>
                            </tr>
                            <?php endif; ?>


                            <!--TOTAL NUMBER OF BAGS-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_TOTAL_NUMBER_OF_BAGS, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_TOTAL_NUMBER_OF_BAGS]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center"><span class="text-primary text-semibold"><?=$data['value']?></span></td>
                            </tr>
                            <?php endif; ?>


                            <!--NUT WEIGHT-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_NUT_WEIGHT, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_NUT_WEIGHT]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center"><span class="text-primary text-semibold"><?=$data['value']?>g</span></td>
                            </tr>
                            <?php endif; ?>


                            <!--NUT COUNT-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_NUT_COUNT, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_NUT_COUNT]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center"><span class="text-primary text-semibold"><?=$data['value']?></span></td>
                            </tr>
                            <?php endif; ?>


                            <!--MOISTURE CONTENT-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_MOISTURE_CONTENT, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_MOISTURE_CONTENT]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center"><span class="text-warning text-semibold"><?=$data['value']?>%</span></td>
                            </tr>
                            <?php endif; ?>

                            <!--FOREIGN MATERIAL-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_FOREIGN_MATERIAL, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_FOREIGN_MATERIAL]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_FOREIGN_MATERIAL, $measurement)['updated_at']?></small>
                                </td>
                                <td class="text-center"><span class="text-danger text-semibold"><?=QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_FOREIGN_MATERIAL, $measurement)['value']?>g</span></td>
                            </tr>
                            <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <table class="table table-vcenter" style="width: auto">
                            <tbody>

                            <!--GOOD KERNEL-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_GOOD_KERNEL, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_GOOD_KERNEL]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center"><span class="text-success text-semibold"><?=$data['value']?>g</span></td>
                            </tr>
                            <?php endif; ?>

                            <!--SPOTTED KERNEL-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_SPOTTED_KERNEL, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_SPOTTED_KERNEL]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center">
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","With shell")?>"><?=$data['value_with_shell']?>g</span>
                                    /
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","Without shell")?>"><?=$data['value_without_shell']?>g</span>
                                </td>
                            </tr>
                            <?php endif; ?>


                            <!--IMMATURE KERNEL-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_IMMATURE_KERNEL, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_IMMATURE_KERNEL]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center">
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","With shell")?>"><?=$data['value_with_shell']?>g</span>
                                    /
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","Without shell")?>"><?=$data['value_without_shell']?>g</span>

                                </td>
                            </tr>
                            <?php endif; ?>

                            <!--OILY KERNEL-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_OILY_KERNEL, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_OILY_KERNEL]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center">
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","With shell")?>"><?=$data['value_with_shell']?>g</span>
                                    /
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","Without shell")?>"><?=$data['value_without_shell']?>g</span>

                                </td>
                            </tr>
                            <?php endif; ?>

                            <!--OILY KERNEL-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_BAD_KERNEL, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_BAD_KERNEL]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center">
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","With shell")?>"><?=$data['value_with_shell']?>g</span>
                                    /
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","Without shell")?>"><?=$data['value_without_shell']?>g</span>

                                </td>
                            </tr>
                            <?php endif; ?>

                            <!--VOID KERNEL-->
                            <?php
                            $data = QarDetail::findOneMeasurementFromQarDetailsArray(Qar::FIELD_VOID_KERNEL, $measurement);
                            if(!empty($data)): ?>
                            <tr>
                                <td>
                                    <span class="text-main text-semibold"><?=Qar::qarMeasurementFieldLabels()[Qar::FIELD_VOID_KERNEL]?></span>
                                    <br>
                                    <small class="text-muted"><?=Yii::t("app", "Added on")?> : <?=$data['updated_at']?></small>
                                </td>
                                <td class="text-center">
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","With shell")?>"><?=$data['value_with_shell']?>g</span>
                                    /
                                    <span class="text-warning text-semibold add-tooltip" data-toggle="tooltip" data-original-title="<?=Yii::t("app","Without shell")?>"><?=$data['value_without_shell']?>g</span>

                                </td>
                            </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>