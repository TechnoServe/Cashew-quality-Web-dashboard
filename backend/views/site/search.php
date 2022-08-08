<?php
$this->title = Yii::t("app", "Search");
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if($resultCount == 0): ?>
<div class="panel panel-body text-center">
    <div class="panel-heading">
        <div class="pad-hor mar-top">
            <h2 class="text-thin mar-no">0 <?=Yii::t("app","results found for")?> <i class="text-info text-normal">"<?=$q?>"</i></h2>
        </div>
    </div>
    <div class="panel-body">
        <p><?=Yii::t("app", "Please check your spelling, or you can click on individual menu butttons to filter for specific items")?></p>
    </div>
</div>
<?php endif; ?>


<?php if($resultCount > 0): ?>
<div class="panel">
    <div class="panel-body">
    <div class="pad-hor mar-top">
        <h2 class="text-thin mar-no"><?=$resultCount?> <?=Yii::t("app","results found for")?> <i class="text-info text-normal">"<?=$q?>"</i></h2>
    </div>

    <hr>

    <ul class="list-group bord-no">
        <li class="list-group-item list-item-lg">
            <div class="media-heading mar-no">
                <a class="btn-link text-lg text-semibold" href="<?=\yii\helpers\Url::to(["qar/index"])?>"><?=Yii::t("app", "Qaulity Audit Requests")?></a>
            </div>
            <hr>
            <p class="text-sm">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
            <div class="pad-lft mar-top">
                <div class="row">
                    <div class="col-sm-4">
                        <a class="btn-link text-semibold" href="#">Download</a>
                        <p>Authoritatively procrastinate long-term high-impact best practices after visionary platforms...</p>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn-link text-semibold" href="#">Pricing</a>
                        <p>Enthusiastically provide access to extensive testing procedures enabled communities...</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <a class="btn-link text-semibold" href="#">Comments</a>
                        <p>Collaboratively disseminate B2C networks after stand-alone synergy. Continually promote...</p>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn-link text-semibold" href="#">Reviews</a>
                        <p>Uniquely target visionary methods of empower after multimedia based...</p>
                    </div>
                </div>
            </div>
        </li>
        <li class="list-group-item list-item-lg">
            <div class="media-heading mar-no">
                <a class="btn-link text-lg text-semibold" href="#">Theme Features</a>
            </div>
            <p><a class="btn-link text-success box-inline" href="#">http://www.example.com/nifty/admin</a></p>
            <p class="text-sm">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
        </li>
        <li class="list-group-item list-item-lg media">
            <div class="pull-left">
                <img class="img-lg" alt="Image" src="img/thumbs/img2.jpg">
            </div>
            <div class="media-body">
                <div class="media-heading mar-no">
                    <a class="btn-link text-lg text-semibold" href="#">Beautiful Nature | Landscapes Wallpapers</a>
                </div>
                <p><a class="btn-link text-success" href="#">http://www.example.com/nifty/admin</a></p>
                <p class="text-sm">Lorem ipsum dolor sit amet, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
            </div>
        </li>
        <li class="list-group-item list-item-lg">
            <div class="media-heading">
                <a class="btn-link text-lg text-semibold" href="#">Tags</a>
            </div>
            <p><a class="btn-link text-success" href="#">http://www.example.com/nifty/admin</a></p>
            <p class="text-sm">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.</p>

            <div class="pad-btm">
                <small>Tags :</small>
                <a class="label label-mint" href="#">Lorem</a>
                <a class="label label-purple" href="#">Ipsum</a>
                <a class="label label-success" href="#">Dolor</a>
            </div>
        </li>
        <li class="list-group-item list-item-lg">
            <div class="media-heading">
                <a class="btn-link text-lg text-semibold" href="#">Trending Topics | Twitter</a>
            </div>
            <p><a class="btn-link text-success" href="#">http://www.example.com/nifty/admin</a></p>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. </p>
        </li>
        <li class="list-group-item list-item-lg">
            <div class="media-heading">
                <span class="label label-primary v-middle">New</span>
                <a class="btn-link text-lg text-semibold v-middle" href="#">Label</a>
            </div>
            <p><a class="btn-link text-success" href="#">http://www.example.com/nifty/admin</a></p>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>
        </li>
    </ul>
    <hr class="hr-wide">

    <!--Pagination-->
    <div class="text-center">
        <ul class="pagination mar-no">
            <li class="disabled"><a class="demo-pli-arrow-left" href="#"></a></li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><span>...</span></li>
            <li><a href="#">20</a></li>
            <li><a class="demo-pli-arrow-right" href="#"></a></li>
        </ul>
    </div>
</div>
</div>
<?php endif; ?>
