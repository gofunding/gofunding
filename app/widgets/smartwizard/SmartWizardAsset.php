<?php
namespace app\widgets\smartwizard;

use yii\web\AssetBundle;
/**
 * Asset bundle for the smart wizard files.
 *
 * @author kuakling <kuakling@gmail.com>
 * @since 2.0
 */
class SmartWizardAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/smartwizard/dist';
    
    public $css = [
        // 'css/smart_wizard.css',
    ];
    
    public $js = [
        'js/jquery.smartWizard.min.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
