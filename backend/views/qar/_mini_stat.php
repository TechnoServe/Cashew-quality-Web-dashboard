<div class="row">
    <div class="col-md-12 col-sm-6">
        <div class="panel panel-warning panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-geo-2-plus icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold"><?=number_format($qarsToBeDone, 0, 0, " ")?></p>
                <p class="mar-no"> <?= Yii::t("app", "To be Done")?></p>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-6">
        <div class="panel panel-info panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-notepad icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold"><?=number_format($qarsInProgress, 0, 0, " ")?></p>
                <p class="mar-no"><?= Yii::t("app", "In Progress")?></p>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-6">
        <div class="panel panel-mint panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-approved-window icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold"><?=number_format($qarsCompleted, 0, 0, " ")?></p>
                <p class="mar-no"><?= Yii::t("app", "Completed")?></p>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-6">
        <div class="panel panel-danger panel-colorful media middle pad-all">
            <div class="media-left">
                <div class="pad-hor">
                    <i class="pli-geo-2-close icon-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <p class="text-2x mar-no text-semibold"><?=number_format($qarsCanceled, 0, 0, " ")?></p>
                <p class="mar-no"><?= Yii::t("app", "Canceled")?></p>
            </div>
        </div>
    </div>
</div>