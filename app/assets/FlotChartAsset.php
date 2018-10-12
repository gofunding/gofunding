<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FlotChartAsset extends AssetBundle {

    public $sourcePath = '@app/themes/adminlte';
//    public $css = [];
    public $js = [
        'bower_components/Flot/jquery.flot.js',
        'bower_components/Flot/jquery.flot.pie.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
