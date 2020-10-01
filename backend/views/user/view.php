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
        <?php if($model->id != Yii::$app->user->getId()): ?>
            <h3 class="panel-title"><?=Yii::t("app", "User profile")?></h3>
        <?php else: ?>
            <h3 class="panel-title"><?=Yii::t("app", "My profile")?></h3>
        <?php endif; ?>
    </div>

    <div class="panel-body">

        <?php $role =  Yii::$app->user->getIdentity()->role; if($role == User::ROLE_ADMIN || $role == User::ROLE_INSTITUTION_ADMIN): ?>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']) ?>

            <?php if($model->status == User::STATUS_ACTIVE && $model->id != Yii::$app->user->getId()): ?>
            <?= Html::a(Yii::t('app', 'Deactivate'), ['deactivate', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app',
                            'Are you sure you want to deactivate this user?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>

            <?php if($model->status == User::STATUS_INACTIVE && $model->id != Yii::$app->user->getId()):?>
                <?= Html::a(Yii::t('app', 'Re-activate'), ['reactivate', 'id' => $model->id],
                    [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => Yii::t('app',
                                'Are you sure you want to restore this user?'),
                            'method' => 'post',
                        ],
                    ]) ?>
            <?php endif; ?>

            <?php if($model->id != Yii::$app->user->getId()):?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-default',
                    'data' => [
                        'confirm' => Yii::t('app',
                            'Are you sure you want to restore this user?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </p>

        <?php endif; ?>

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