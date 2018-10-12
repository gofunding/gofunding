<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author haifahrul <haifahrul@gmail.com>
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@publicUrl';
    public $css = [
        'css/owl.carousel.min.css',
        'css/owl.theme.green.min.css',
        'css/site.css',
        'css/style.css',
    ];
    public $js = [
        'js/typed.min.js',
        'js/owl.carousel.min.js',
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',  
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
}
