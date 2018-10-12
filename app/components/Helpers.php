<?php
/**
 * User: haifahrul <haifahrul@gmail.com>
 * Date: 7/4/2018
 * Time: 12:59
 */
namespace app\components;

use Yii;
use yii\helpers\ArrayHelper;

class Helpers {
    public function displayImage($folder, $filename) {

        if (!empty($filename) && file_exists(Yii::$app->params['uploadPath'] . $folder .'/'. $filename)) {
        	$result = Yii::$app->params['uploadUrl'] . $folder .'/'. $filename;
        } else {
        	$result = Yii::$app->params['defaultImage'];
        }

        return $result;
    }
}