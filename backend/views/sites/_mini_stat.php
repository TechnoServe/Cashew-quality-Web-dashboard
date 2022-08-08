
<div class="panel">
    <div class="panel-body text-center">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-xs-5">
                    <div class="media">
                        <div class="media-left">
                            <span class="text-4x text-thin text-main"><?=number_format($totalSites, 0, 0, " ")?></span>
                            <p class="text-sm text-bold text-uppercase"><?=Yii::t("app", "Total sites registered")?></p>

                        </div>
                    </div>
                </div>
                <div class="col-xs-7 text-sm">
                    <p>
                        <span class="text-lg pad-lft text-semibold"><?=number_format($totalSitesWithoutImages, 0, 0, " ")?></span>
                        <br>
                        <span class="pad-lft text-semibold"><?=Yii::t("app", "Waiting for Image upload")?></span>
                    </p>
                    <hr>
                    <p>
                        <span class="text-lg pad-lft text-semibold"><?=number_format($totalSitesWithoutSiteLocation, 0, 0, " ")?></span>
                        <br>
                        <span class="pad-lft text-semibold"><?=Yii::t("app", "Awaiting map location")?></span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8" style="height: 100%;line-height: 20px; padding: 2%;">
            <div class="pad-rgt">
                <ul class="text-left">
                    <li>
                        <?=Yii::t("app", "Every site should have its picture uploaded, this helps in enriching information about the site")?>
                    </li>
                    <li>
                        <?=Yii::t("app", "Every site should have its map location details entered, this helps in showing a Google map with a marker to the exact location of the site")?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>