<?php
namespace app\widgets\adminlte;

use Yii;

class AdminLteHelper
{
    /**
     * It allows you to get the name of the CSS class.
     * You can add the appropriate class to the body tag for dynamic change the template's appearance.
     * Note: Use this function only if you override the skin through configuration. 
     * Otherwise you will not get the correct CSS class of body.
     * 
     * @return string
     */
    public static function skinClass()
    {
        /** @var \app\assets\AdminLteAsset $bundle */
        $bundle = Yii::$app->assetManager->getBundle('app\assets\AdminLteAsset');

        return $bundle->skin;
    }
}
