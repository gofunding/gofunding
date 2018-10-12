<?php

namespace app\widgets\toastr;

use yii\web\AssetBundle;

class ToastrCustomAsset extends AssetBundle {

    public $sourcePath;

    public function __construct() {
        $this->sourcePath = __DIR__ . '/assets';
    }

    public $baseUrl = '@web';
    public $css = [
        'toastr-style-reset.css',
    ];
    
    public $depends = [
        'app\widgets\toastr\ToastrAsset',
    ];

}
