<?php
namespace app\assets;

use yii\base\Exception;
use yii\web\AssetBundle as BaseAdminLteAsset;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class EditorAsset extends BaseAdminLteAsset
{
    public $sourcePath = '@app/themes/adminlte';
    public $css = [
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'
    ];
    public $js = [
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'bower_components/ckeditor/ckeditor.js'
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',        
    ];
}
