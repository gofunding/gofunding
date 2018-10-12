<?php

namespace app\widgets\toastr;

use yii\web\AssetBundle;

/**
 * Description of ToastrAsset
 *
 * @author Odai Alali <odai.alali@gmail.com>
 */
class ToastrAsset extends AssetBundle {

    public $sourcePath;

    public function __construct() {
        $this->sourcePath = __DIR__ . '/assets';
    }

    public $baseUrl = '@web';
    public $css = [
        'toastr.min.css',
    ];
    public $js = [
        'toastr.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
