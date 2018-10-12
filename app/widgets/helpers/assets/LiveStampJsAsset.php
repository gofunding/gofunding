<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets\helpers\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LiveStampJsAsset extends AssetBundle {

    public $sourcePath = '@app/widgets/helpers/libraries/livestampjs/';
    public $css = [
    ];
    public $js = [
        'livestamp.min.js',
    ];
    public $depends = [
        'app\widgets\helpers\assets\MomentJsAsset',
    ];

}
