<?php


namespace backend\assets;


use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'nifty/css/nifty.min.css',
        'nifty/css/pace.min.css',
        'nifty/premium/icon-sets/icons/line-icons/premium-line-icons.min.css',
        'nifty/premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css',
        'nifty/css/demo/nifty-demo.css',
        'nifty/css/flag-icon-css/css/flag-icon.css',
    ];
    public $js = [
        'nifty/js/jquery-1.11.2.min.js',
        'nifty/js/bootstrap.min.js',
        //'nifty/js/bootstrap-select.min.js',
        'nifty/js/nifty.min.js',
        'nifty/js/pace.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}