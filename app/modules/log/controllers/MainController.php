<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\log\controllers;

/**
 * Description of MainController
 *
 * @author haifahrul
 */
class MainController extends \yii\web\Controller {

    public function afterAction($action, $result) {        
        \Yii::$app->actionLogs->setLog($action);

        return parent::afterAction($action, $result);
    }
            
}
