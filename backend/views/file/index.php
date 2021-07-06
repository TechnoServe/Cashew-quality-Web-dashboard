<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Files');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading bg-primary" style="width: 100%">
                <h3 class="panel-title"><?= Yii::t("app", "Terms and Conditions") ?></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive" style="width: 100%">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>
                                <?=Html::a("English", ['file/terms', 'locale' => 'en'], ['class'=>'btn-link', 'target'=>'_blank'])?>
                                <?php if($terms_en): ?>
                                    <div class="label label-success"><?=Yii::t("app", "Available")?></div>
                                    <?=Html::a(Yii::t("app", "Delete"),['/file/delete-terms', 'locale' => 'en'],['class'=>'btn-link text-danger',
                                        'data' => [
                                            'method'=> 'post',
                                            'confirm' => Yii::t("app", "Are you sure you want to delete this file")
                                        ]])?>
                                <?php else: ?>
                                    <div class="label label-warning"><?=Yii::t("app", "Not Available")?></div>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?=Html::a("Français", ['file/terms', 'locale' => 'fr'], ['class'=>'btn-link', 'target'=>'_blank'])?>
                                <?php if($terms_fr): ?>
                                    <div class="label label-success"><?=Yii::t("app", "Available")?></div>
                                    <?=Html::a(Yii::t("app", "Delete"),['/file/delete-terms', 'locale' => 'fr'],['class'=>'btn-link text-danger',
                                        'data' => [
                                            'method'=> 'post',
                                            'confirm' => Yii::t("app", "Are you sure you want to delete this file")
                                        ]])?>
                                <?php else: ?>
                                    <div class="label label-warning"><?=Yii::t("app", "Not Available")?></div>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?=Html::a("Português", ['file/terms', 'locale' => 'pt'], ['class'=>'btn-link', 'target'=>'_blank'])?>
                                <?php if($terms_pt): ?>
                                    <div class="label label-success"><?=Yii::t("app", "Available")?></div>
                                    <?=Html::a(Yii::t("app", "Delete"),['/file/delete-terms', 'locale' => 'pt'],['class'=>'btn-link text-danger',
                                        'data' => [
                                            'method'=> 'post',
                                            'confirm' => Yii::t("app", "Are you sure you want to delete this file")
                                        ]])?>
                                <?php else: ?>
                                    <div class="label label-warning"><?=Yii::t("app", "Not Available")?></div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel-footer">
                <div class="row">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'method' => 'post', 'action' => ['/file/upload-terms']]) ?>
                    <div class="col-md-4">
                        <?= $form->field($fileUploadForm, 'language')->dropDownList(["en" => "English", "fr" => "Français", "pt" => "Português"])->label(Yii::t("app", "Language")) ?>
                        <?= $form->field($fileUploadForm, 'file')->fileInput(['accept' => 'application/pdf'])->label(Yii::t("app", "Terms and conditions")) ?>
                        <?=Html::submitButton(Yii::t("app", "Upload"), [ "class"=>"btn btn-success"]) ?>

                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading bg-primary">
                <h3 class="panel-title"><?= Yii::t("app", "Privacy policy") ?></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive" style="width: 100%">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>
                                <?=Html::a("English", ['file/policy', 'locale' => 'en'], ['class'=>'btn-link', 'target'=>'_blank'])?>
                                <?php if($policy_en): ?>
                                    <div class="label label-success"><?=Yii::t("app", "Available")?></div>
                                    <?=Html::a(Yii::t("app", "Delete"),['/file/delete-privacy', 'locale' => 'en'],['class'=>'btn-link text-danger',
                                        'data' => [
                                            'method'=> 'post',
                                            'confirm' => Yii::t("app", "Are you sure you want to delete this file")
                                        ]])?>
                                <?php else: ?>
                                    <div class="label label-warning"><?=Yii::t("app", "Not Available")?></div>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?=Html::a("Français", ['file/policy', 'locale' => 'fr'], ['class'=>'btn-link', 'target'=>'_blank'])?>
                                <?php if($policy_fr): ?>
                                    <div class="label label-success"><?=Yii::t("app", "Available")?></div>
                                    <?=Html::a(Yii::t("app", "Delete"),['/file/delete-privacy', 'locale' => 'fr'],['class'=>'btn-link text-danger',
                                        'data' => [
                                            'method'=> 'post',
                                            'confirm' => Yii::t("app", "Are you sure you want to delete this file")
                                        ]])?>
                                <?php else: ?>
                                    <div class="label label-warning"><?=Yii::t("app", "Not Available")?></div>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?=Html::a("Português", ['file/policy', 'locale' => 'pt'], ['class'=>'btn-link', 'target'=>'_blank'])?>
                                <?php if($policy_pt): ?>
                                    <div class="label label-success"><?=Yii::t("app", "Available")?></div>
                                    <?=Html::a(Yii::t("app", "Delete"),['/file/delete-privacy', 'locale' => 'pt'],['class'=>'btn-link text-danger',
                                        'data' => [
                                            'method'=> 'post',
                                            'confirm' => Yii::t("app", "Are you sure you want to delete this file")
                                        ]])?>
                                <?php else: ?>
                                    <div class="label label-warning"><?=Yii::t("app", "Not Available")?></div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel-footer">
                <div class="row">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'method' => 'post', 'action' => ['/file/upload-privacy']]) ?>
                    <div class="col-md-4">
                        <?= $form->field($fileUploadForm, 'language')->dropDownList(["en" => "English", "fr" => "Français", "pt" => "Português"])->label(Yii::t("app", "Language")) ?>
                        <?= $form->field($fileUploadForm, 'file')->fileInput(['accept' => 'application/pdf'])->label(Yii::t("app", "Privacy policy")) ?>
                        <?=Html::submitButton(Yii::t("app", "Upload"), [ "class"=>"btn btn-success"]) ?>

                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>



