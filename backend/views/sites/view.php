<?php

use backend\models\Company;
use voime\GoogleMaps\Map;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;
use yii2mod\google\maps\markers\GoogleMaps;

/* @var $this yii\web\View */
/* @var $model backend\models\Site */



$this->title = $model->site_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?=$this->registerCss("
#map img
    {
        max-width: none;
    }")?>

<div class="panel">

    <div class="panel-heading bg-primary">
        <h3 class="panel-title"><?=Yii::t("app", "Site Details")?></h3>
    </div>
    <div class="panel-body">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= $this->render('_view_site', ['model' => $model]);?>

        <?php if(!empty($model->map_location)): ?>
    <div id="map">

        <?= Map::widget([
            'zoom' => 15,
            'center' => [(double)$model->latitude, (double)$model->longitude],
            'markers' => [
                ['position' => [(double)$model->latitude, (double)$model->longitude]],
            ],
            'height' => '400px',
            'mapType' => Map::MAP_TYPE_HYBRID,
        ]);
        ?>
    </div>

        <?php endif; ?>
    </div>
</div>

<div class="panel">

    <div class="panel-heading bg-primary">

        <h3 class="panel-title">
            <?=Html::a(Yii::t("app", "Latest QAR(s) on this site"), ["qar/index", "site"=>$model->id], ["class"=>'btn-link'])?>
        </h3>
    </div>

    <div class="panel-body">
        <?= $this->render('../qar/_grid_view', ['dataProvider' => $qarListDataProvider, 'summary' => false]); ?>
    </div>

</div>


