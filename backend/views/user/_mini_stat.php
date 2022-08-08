<?php

use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-4 col-sm-4">
        <a href="<?php echo Url::to(['/user/index']) ?>">
            <div class="panel panel-success panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="pli-male icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold"><?= number_format($totalUsers, 0, 0, " ") ?></p>
                    <p class="mar-no"> <?= Yii::t("app", "Total Users") ?></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 col-sm-4">
        <a href="<?php echo Url::to(['/user/index', "role" => 5]) ?>">
            <div class="panel panel-warning panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="pli-worker icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold"><?= number_format($totalFieldTech, 0, 0, " ") ?></p>
                    <p class="mar-no"> <?= Yii::t("app", "Field Tech") ?></p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 col-sm-4">
        <a href="<?php echo Url::to(['/user/index', "role" => 6]) ?>">
            <div class="panel panel-primary panel-colorful media middle pad-all">
                <div class="media-left">
                    <div class="pad-hor">
                        <i class="pli-business-man icon-3x"></i>
                    </div>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold"><?= number_format($totalBuyer, 0, 0, " ") ?></p>
                    <p class="mar-no"><?= Yii::t("app", "Buyer") ?></p>
                </div>
            </div>
        </a>
    </div>
</div>