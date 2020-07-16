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

<?= $this->render('_mini_stat', [
            'qarsInProgress' => $qarsInProgress,
            'qarsToBeDone' => $qarsToBeDone,
            'qarsCompleted' => $qarsCompleted,
            'qarsCanceled' => $qarsCanceled
    ]); ?>


<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?=Yii::t("app", "Search form")?></h3>
    </div>

    <div class="panel-body">
        <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <hr>

    <div class="panel-heading">
        <p class="pull-right pad-all">
            <?= Html::a(Yii::t('app', 'Create Qar'), ['create'],
                ['class' => 'btn btn-success']) ?>
        </p>
        <h3 class="panel-title"><?=Yii::t("app", "Search results")?></h3>
    </div>

    <div class="panel-body">
        <div class="table-responsive" style="width: 100%">
            <?= $this->render('_grid_view', ['dataProvider' => $dataProvider]); ?>
        </div>
    </div>

</div>
