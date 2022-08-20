<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.6',
        'assets/plugins/global/plugins.bundle.css?v=7.0.6',
        'assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6',
        'assets/css/style.bundle.css?v=7.0.6',
        'assets/css/themes/layout/header/base/light.css?v=7.0.6',
        'assets/css/themes/layout/header/menu/light.css?v=7.0.6',
        'assets/css/themes/layout/brand/dark.css?v=7.0.6',
        'assets/css/themes/layout/aside/dark.css?v=7.0.6',
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
