<?php

use backend\models\Company;
use backend\models\Department;
use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="row">
    <div class="col-md-6">
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
                    'attribute' => 'department_id',
                    'value' => function($model) {
                        $department = Department::findOne($model->department_id);
                        return $department ? $department->name : null;
                    }
                ],
                'site_name',
                'site_location:ntext',
                'map_location',
                'created_at',
                'updated_at',
            ],
        ]) ?>
    </div>

    <div class="col-md-6" style="height: 250px;">
        <?=Html::img($model->getImagePath(), ["style"=>"background-size: contain; background-repeat: no-repeat; background-position: center; display: block;width: auto;height: 100%;"])?>
    </div>

</div>