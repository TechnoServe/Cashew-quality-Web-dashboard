<?php

use backend\models\Company;
use backend\models\User;
use common\helpers\CashewAppHtmlHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<!--MAIN NAVIGATION-->
<!--===================================================-->

<style>
    @media only screen and (max-width: 770px) {
        .mainnav-container {
            margin-top: -5px !important;
        }
    }
</style>


<nav id="mainnav-container" style="margin-top: -60px; z-index:999999999; position: fixed">

    <div id="mainnav">

        <div class="visible-xs" style="height: 50px">

        </div>

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

                            <img class="img-md mar-btm" src="<?= Url::to("@web/img/CashewNuts-Logo.png") ?>" alt="CNQA Logo">

                            <?php if (Yii::$app->user->identity->role != User::ROLE_ADMIN && Yii::$app->user->identity->role != User::ROLE_ADMIN_VIEW) : ?>
                                <?php $company = Company::findOne(Yii::$app->user->identity->company_id);?>
                                <h4> <strong> <?= $company->name ?> </strong></h4>
                            <?php endif; ?>
                            <p class="box-bock text-bold"> <span class="badge badge-success"> <?= User::getUserRole()[Yii::$app->user->identity->role] ?> </span></p>
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
                        <li class="list-header"> <?= Yii::t("app", "Navigation") ?> </li>

                        <?= CashewAppHtmlHelper::showMenuContent('HOME', 'pli-home', Yii::t('app', 'Dashboard')) ?>

                        <?= CashewAppHtmlHelper::showMenuContent('qar', 'pli-receipt-4', Yii::t('app', 'QAR')) ?>

                        <?php if (
                            Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN_VIEW
                        ) :
                        ?>
                            <?= CashewAppHtmlHelper::showMenuContent('free', 'pli-bar-chart', Yii::t('app', 'Free version data')) ?>
                        <?php endif; ?>

                        <?php if (
                            Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_INSTITUTION_ADMIN
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_INSTITUTION_ADMIN_VIEW
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_FIELD_TECH
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN_VIEW
                        ) :
                        ?>

                            <li class="list-divider"></li>

                            <li class="list-header"><?= Yii::t("app", "Administration") ?></li>

                        <?php endif; ?>

                        <?php if (
                            Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_INSTITUTION_ADMIN
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_INSTITUTION_ADMIN_VIEW
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN_VIEW
                        ) :
                        ?>

                            <?= CashewAppHtmlHelper::showMenuContent('sites', 'pli-map', Yii::t('app', 'Sites')) ?>

                            <?= CashewAppHtmlHelper::showMenuContent('user', 'pli-male', Yii::t('app', 'Users')) ?>

                        <?php endif; ?>

                        <?php if (
                            Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_INSTITUTION_ADMIN
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_INSTITUTION_ADMIN_VIEW
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_FIELD_TECH
                            || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN_VIEW
                        ) :
                        ?>

                            <?= CashewAppHtmlHelper::showMenuContent('user-equipment', 'pli-gears', Yii::t('app', 'Equipments')) ?>

                        <?php endif; ?>

                        <?php if (Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN || Yii::$app->user->getIdentity()->role == \common\models\User::ROLE_ADMIN_VIEW) : ?>

                            <?= CashewAppHtmlHelper::showMenuContent('company', 'pli-building', Yii::t('app', 'Companies')) ?>

                            <?= CashewAppHtmlHelper::showMenuContent('province', 'pli-location-2', Yii::t('app', 'Provinces')) ?>

                        <?php endif; ?>

                    </ul>

                    <div id="mainnav-profile" class="mainnav-profile">
                        <div class="profile-wrap text-center">
                            <div class="pad-btm">
                                <?= Html::img('@web/img/TechnoServe-Logo.png', ['alt' => 'TechnoServe-Logo', 'class' => 'img-lg', 'style' => ['width' => "120px", "height" => "auto"]]) ?>
                            </div>
                            <a target="_blank" href="<?= Url::to("http://tns.org/") ?>" class="box-block">
                                <span class="mnp-desc"> <?= Yii::t("app", "Powered by TechnoServe") ?></span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
<!--===================================================-->
<!--END MAIN NAVIGATION-->