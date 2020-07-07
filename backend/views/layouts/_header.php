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
        <div class="navbar-header">
            <a href="index.html" class="navbar-brand">
                <img src="<?=Url::to("/nifty/img/logo.png")?>" alt="Nifty Logo" class="brand-icon">
                <div class="brand-title">
                    <span class="brand-text">TNS</span>
                </div>
            </a>
        </div>
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
                                <span class="ic-user pull-right">
                                    <i class="demo-pli-male icon-fw"></i><?=Yii::$app->user->identity->first_name?> <?=Yii::$app->user->identity->middle_name?> <?=Yii::$app->user->identity->last_name?>

                                </span>
                    </a>


                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                        <ul class="head-list">
                            <li>
                                <a href="#"><i class="demo-pli-male icon-lg icon-fw"></i> Profile</a>
                            </li>
                            <li>
                                <a href="#"><span class="label label-success pull-right">New</span><i
                                        class="demo-pli-gear icon-lg icon-fw"></i> Settings</a>
                            </li>
                            <li>
                                <a href="<?=Url::to(['/site/logout'])?>" data-method="post"><i class="demo-pli-unlock icon-lg icon-fw"></i>
                                    Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->


                <!--language switcher-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                            <span class="ic-user pull-right">
                                <i class="flag-icon flag-icon-<?=Yii::$app->language == "en" ? "gb" : Yii::$app->language?> icon-fw"></i> <?= User::getLanguagesDropDownList()[Yii::$app->language] ?>
                            </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                        <ul class="head-list">
                            <li>
                                <a href="<?=Url::to(["site/switch-user-language", "language" => "en"])?>"><i class="flag-icon flag-icon-gb icon-fw"></i> English </a>
                            </li>
                            <li>
                                <a href="<?=Url::to(["site/switch-user-language", "language" => "fr"])?>"><i class="flag-icon flag-icon-fr pli-globe icon-lg icon-fw"></i> Français</a>                                </li>
                            <li>
                                <a href="<?=Url::to(["site/switch-user-language", "language" => "pt"])?>"><i class="flag-icon flag-icon-pt pli-globe icon-lg icon-fw"></i> Português</a>
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