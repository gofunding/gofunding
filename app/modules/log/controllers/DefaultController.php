<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\log\controllers;

/**
 * Description of DefaultController
 *
 * @author haifahrul
 */
use Yii;

class DefaultController extends MainController {

    public function actionIndex() {
        return $this->redirect('/log/login/');
    }

}
