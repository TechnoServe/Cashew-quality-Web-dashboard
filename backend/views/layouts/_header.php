<?php

use backend\models\User;
use yii\helpers\Url;

?>
<!--NAVBAR-->
<!--===================================================-->
<header id="navbar">
    <div id="navbar-container" class="boxed">

        <!--Brand logo & name-->
        <!--================================-->

        <!--================================-->
        <!--End brand logo & name-->

        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content">
            <ul class="nav navbar-top-links">

                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#">
                        <i class="demo-pli-list-view"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->



            </ul>

            <ul class="nav navbar-top-links">

                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <?=Yii::$app->user->identity->first_name?> <?=Yii::$app->user->identity->middle_name?> <?=Yii::$app->user->identity->last_name?> <i class="demo-pli-male icon-fw"></i>
                    </a>


                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                        <ul class="head-list">
                            <li>
                                <a href="<?=Url::to(["user/view", "id"=>Yii::$app->user->getId()])?>"><i class="demo-pli-male icon-fw"></i> <?= Yii::t("app", "Profile") ?></a>
                            </li>
                            <li>
                                <a href="<?=Url::to(["user/update", "id"=>Yii::$app->user->getId()])?>">
                                    <i class="demo-pli-gear icon-fw"></i> <?= Yii::t("app", "Settings") ?></a>
                            </li>
                            <li>
                                <a href="<?=Url::to(['/site/logout'])?>" data-method="post"><i class="demo-pli-unlock icon-fw"></i>
                                    <?= Yii::t("app", "Logout") ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->


                <!--language switcher-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <?= User::getLanguagesDropDownList()[Yii::$app->language] ?>   <i class="flag-icon flag-icon-<?=Yii::$app->language == "en" ? "gb" : Yii::$app->language?> icon-fw"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                        <ul class="head-list">
                            <li>
                                <a href="<?=Url::to(["site/switch-user-language", "language" => "en"])?>"><i class="flag-icon flag-icon-gb icon-fw"></i> English </a>
                            </li>
                            <li>
                                <a href="<?=Url::to(["site/switch-user-language", "language" => "fr"])?>"><i class="flag-icon flag-icon-fr pli-globe icon-fw"></i> Français</a>                                </li>
                            <li>
                                <a href="<?=Url::to(["site/switch-user-language", "language" => "pt"])?>"><i class="flag-icon flag-icon-pt pli-globe icon-fw"></i> Português</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--language switcher-->
            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>
<!--===================================================-->
<!--END NAVBAR-->