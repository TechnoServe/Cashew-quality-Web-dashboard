<?php

use backend\models\Company;
use backend\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">


    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?=Yii::t("app", "User details")?></h3>
    </div>

    <div class="panel-body">

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']) ?>

            <?php if($model->status == User::STATUS_ACTIVE): ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app',
                            'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>

            <?php if($model->status == User::STATUS_INACTIVE): ?>
                <?= Html::a(Yii::t('app', 'Re-activate'), ['restore', 'id' => $model->id],
                    [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => Yii::t('app',
                                'Are you sure you want to restore this user?'),
                            'method' => 'post',
                        ],
                    ]) ?>
            <?php endif; ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',
                'first_name',
                'middle_name',
                'last_name',
                [
                    'attribute' => 'company_id',
                    'value' => function ($model) {
                        $company = Company::findOne($model->company_id);
                        return $company ?  $company->name : null;
                    }
                ],
                'email:email',
                'phone',
                'address',
                [
                    'attribute' => 'language',
                    'value' => $model->getLanguageByIndex($model->language),
                ],
                [
                    'attribute' => 'status',
                    'value' => $model->getUserStatusByIndex($model->status),
                ],
                'created_at',
                [
                    'attribute' => 'role',
                    'value' => function ($model) {
                        return User::getUserRole()[$model->role];
                    },
                ],
            ],
        ]) ?>

    </div>

</div>


<?php if($model->role == User::ROLE_FIELD_TECH): ?>
<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?=Html::a(Yii::t("app", "Recent equipments"), ["user-equipment/index", "user_id"=>$model->id], ["class"=>'btn-link'])?></h3>
    </div>

    <div class="panel-body">
        <?= $this->render('../user-equipment/_grid_view', ['dataProvider' => $dataProvider, 'summary' => false]); ?>
    </div>

</div>
    <?php endif; ?>