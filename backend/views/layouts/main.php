<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="container" class="effect aside-float aside-bright mainnav-lg">

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
                                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                    <!--You can use an image instead of an icon.-->
                                    <!--<img class="img-circle img-user media-object" src="img/profile-photos/1.png" alt="Profile Picture">-->
                                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                    <i class="demo-pli-male"></i>
                                </span>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--You can also display a user name in the navbar.-->
                            <!--<div class="username hidden-xs">Aaron Chavez</div>-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
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
                                <i class="psi-globe"></i> English
                            </span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                            <ul class="head-list">
                                <li>
                                    <a href="#"><i class="pli-globe icon-lg icon-fw"></i> English</a>
                                </li>
                                <li>
                                    <a href="#"><i class="pli-globe icon-lg icon-fw"></i> Français</a>                                </li>
                                <li>
                                    <a href="#"><i class="pli-globe icon-lg icon-fw"></i> Português</a>
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

    <div class="boxed">

        <!--CONTENT CONTAINER-->
        <!--===================================================-->
        <div id="content-container">
            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">

                <?=$content?>


            </div>
            <!--===================================================-->
            <!--End page content-->

        </div>
        <!--===================================================-->
        <!--END CONTENT CONTAINER-->




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
                                <li class="list-header">Navigation</li>

                                <!--Menu list item-->
                                <li class="active-sub">
                                    <a href="<?=Url::to(["/"])?>">
                                        <i class="demo-pli-home"></i>
                                        <span class="menu-title">Dashboard</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?=Url::to(["/"])?>">
                                        <i class="demo-pli-receipt-4"></i>
                                        <span class="menu-title">QAR management</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?=Url::to(["/"])?>">
                                        <i class="demo-pli-bar-chart"></i>
                                            <span class="menu-title">Reports</span>
                                    </a>
                                </li>


                                <li class="list-divider"></li>

                                <!--Category name-->
                                <li class="list-header">Management</li>

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

    </div>


    <!-- FOOTER -->
    <!--===================================================-->
    <footer id="footer">

        <!-- Visible when footer positions are fixed -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div class="show-fixed pad-rgt pull-right">

        </div>


        <!-- Visible when footer positions are static -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div class="hide-fixed pull-right pad-rgt">

        </div>


        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- Remove the class "show-fixed" and "hide-fixed" to make the content always appears. -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

        <p class="pad-lft">&#0169; <?= date('Y') ?> TechnoServe</p>


    </footer>
    <!--===================================================-->
    <!-- END FOOTER -->


    <!-- SCROLL PAGE BUTTON -->
    <!--===================================================-->
    <button class="scroll-top btn">
        <i class="pci-chevron chevron-up"></i>
    </button>
    <!--===================================================-->
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
