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


                    <!--Search-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <li>
                        <div class="custom-search-form">
                            <label class="btn btn-trans" for="search-input" data-toggle="collapse"
                                   data-target="#nav-searchbox">
                                <i class="demo-pli-magnifi-glass"></i>
                            </label>
                            <form>
                                <div class="search-container collapse" id="nav-searchbox">
                                    <input id="search-input" type="text" class="form-control"
                                           placeholder="Type for search...">
                                </div>
                            </form>
                        </div>
                    </li>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End Search-->

                </ul>
                <ul class="nav navbar-top-links">

                    <!--Notification dropdown-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                            <i class="demo-pli-bell"></i>
                            <span class="badge badge-header badge-danger"></span>
                        </a>


                        <!--Notification dropdown menu-->
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <div class="nano scrollable">
                                <div class="nano-content">
                                    <ul class="head-list">
                                        <li>
                                            <a href="#" class="media add-tooltip" data-title="Used space : 95%"
                                               data-container="body" data-placement="bottom">
                                                <div class="media-left">
                                                    <i class="demo-pli-data-settings icon-2x text-main"></i>
                                                </div>
                                                <div class="media-body">
                                                    <p class="text-nowrap text-main text-semibold">HDD is full</p>
                                                    <div class="progress progress-sm mar-no">
                                                        <div style="width: 95%;"
                                                             class="progress-bar progress-bar-danger">
                                                            <span class="sr-only">95% Complete</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <i class="demo-pli-file-edit icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">Write a news
                                                        article</p>
                                                    <small>Last Update 8 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <span class="label label-info pull-right">New</span>
                                                <div class="media-left">
                                                    <i class="demo-pli-speech-bubble-7 icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">Comment
                                                        Sorting</p>
                                                    <small>Last Update 8 hours ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <i class="demo-pli-add-user-star icon-2x"></i>
                                                </div>
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">New User
                                                        Registered</p>
                                                    <small>4 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <img class="img-circle img-sm" alt="Profile Picture"
                                                         src="img/profile-photos/9.png">
                                                </div>
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">Lucy sent you
                                                        a message</p>
                                                    <small>30 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="media" href="#">
                                                <div class="media-left">
                                                    <img class="img-circle img-sm" alt="Profile Picture"
                                                         src="img/profile-photos/3.png">
                                                </div>
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">Jackson sent
                                                        you a message</p>
                                                    <small>40 minutes ago</small>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!--Dropdown footer-->
                            <div class="pad-all bord-top">
                                <a href="#" class="btn-link text-main box-block">
                                    <i class="pci-chevron chevron-right pull-right"></i>Show All Notifications
                                </a>
                            </div>
                        </div>
                    </li>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End notifications dropdown-->


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
            <div id="page-head">

                <div class="pad-all text-center">
                    <h3>Welcome back to the Dashboard.</h3>
                    <p>Scroll down to see quick links and overviews of your Server, To do list, Order status or get
                        some Help using Nifty.</p>
                </div>
            </div>


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
                                    <a href="#profile-nav" class="box-block" data-toggle="collapse"
                                       aria-expanded="false">
                                            <span class="pull-right dropdown-toggle">
                                                <i class="dropdown-caret"></i>
                                            </span>
                                        <p class="mnp-name">Aaron Chavez</p>
                                        <span class="mnp-desc">aaron.cha@themeon.net</span>
                                    </a>
                                </div>
                                <div id="profile-nav" class="collapse list-group bg-trans">
                                    <a href="#" class="list-group-item">
                                        <i class="demo-pli-male icon-lg icon-fw"></i> View Profile
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="demo-pli-gear icon-lg icon-fw"></i> Settings
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="demo-pli-information icon-lg icon-fw"></i> Help
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="demo-pli-unlock icon-lg icon-fw"></i> Logout
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
