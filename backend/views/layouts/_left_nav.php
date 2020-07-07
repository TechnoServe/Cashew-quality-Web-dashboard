<?php

use common\helpers\CashewAppHtmlHelper;
use yii\helpers\Url;

?>
<!--MAIN NAVIGATION-->
<!--===================================================-->
<nav id="mainnav-container">
    <div id="mainnav">


        <!--OPTIONAL : ADD YOUR LOGO TO THE NAVIGATION-->
        <!--It will only appear on small screen devices.-->
        <!--================================
        <div class="mainnav-brand">
            <a href="index.html" class="brand">
                <img src="img/logo.png" alt="Nifty Logo" class="brand-icon">
                <span class="brand-text">Nifty</span>
            </a>
            <a href="#" class="mainnav-toggle"><i class="pci-cross pci-circle icon-lg"></i></a>
        </div>
        -->


        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">

                    <!--Profile Widget-->
                    <!--================================-->
                    <div id="mainnav-profile" class="mainnav-profile">
                        <div class="profile-wrap text-center">
                            <div class="pad-btm">
                                <img class="img-circle img-md" src="<?= Url::to("/nifty/img/profile-photos/1.png")?>"
                                     alt="Profile Picture">
                            </div>
                            <a href="<?=Url::to(["user/view/", "id"=>Yii::$app->user->getId()])?>" class="box-block">
                                <p class="mnp-name"><?=Yii::$app->user->identity->first_name?> <?=Yii::$app->user->identity->middle_name?> <?=Yii::$app->user->identity->last_name?></p>
                                <span class="mnp-desc"><?=Yii::$app->user->identity->email?></span>
                            </a>
                        </div>
                    </div>


                    <!--Shortcut buttons-->
                    <!--================================-->
                    <div id="mainnav-shortcut" class="hidden">
                        <ul class="list-unstyled shortcut-wrap">
                            <li class="col-xs-3" data-content="My Profile">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                                        <i class="demo-pli-male"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Messages">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                                        <i class="demo-pli-speech-bubble-3"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Activity">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                        <i class="demo-pli-thunder"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Lock Screen">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                                        <i class="demo-pli-lock-2"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--================================-->
                    <!--End shortcut buttons-->


                    <ul id="mainnav-menu" class="list-group">

                        <!--Category name-->
                        <li class="list-header"> <?=Yii::t("app", "Navigation")?> </li>

                        <?= CashewAppHtmlHelper::showMenuContent('HOME', 'pli-home', Yii::t('app', 'Dashboard'))?>

                        <?= CashewAppHtmlHelper::showMenuContent('qar', 'pli-receipt-4', Yii::t('app', 'QAR'))?>

                        <?= CashewAppHtmlHelper::showMenuContent('report', 'pli-bar-chart', Yii::t('app', 'Reports'))?>


                        <li class="list-divider"></li>

                        <!--Category name-->
                        <li class="list-header"><?=Yii::t("app", "Management")?></li>

                        <?= CashewAppHtmlHelper::showMenuContent('sites', 'pli-map', Yii::t('app', 'Sites management'))?>

                        <!--Menu list item-->
                        <li>
                            <a href="#">
                                <i class="demo-pli-male"></i>
                                <span class="menu-title">Users Management</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="ui-buttons.html">List</a></li>
                                <li><a href="ui-panels.html">New User</a></li>
                            </ul>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
<!--===================================================-->
<!--END MAIN NAVIGATION-->