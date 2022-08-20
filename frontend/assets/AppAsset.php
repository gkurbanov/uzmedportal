<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
        'assets/style/swiper-bundle.min.css',
        'assets/style/style.css',
        'assets/style/custom.css',
    ];
    public $js = [
        'assets/scripts/jquery-3.6.0.min.js',
        'assets/scripts/swiper-bundle.min.js',
        'assets/scripts/bootstrap.bundle.min.js',
        'assets/scripts/script.js',
//        'assets/scripts/custom.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
