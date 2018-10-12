<?php

namespace app\widgets\select2;

class Select2BootstrapAsset extends \yii\web\AssetBundle {

    public $sourcePath = '@app/widgets/select2/assets/bootstrap';
//    public $baseUrl = '@web';
//    public $sourcePath = '@app/themes/adminlte/dist';

    public $css = [
//        'widgets/select2/assets/bootstrap/select2-bootstrap.min.css',
        'select2-bootstrap.min.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
//        'app\widgets\select2\Select2Asset',
    ];

}
