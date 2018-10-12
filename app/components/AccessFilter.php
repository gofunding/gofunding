<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;

/**
 * Description of CheckAccess
 *
 * @author haifahrul
 */
class AccessFilter {

    const R_SUPER_USER = 1;
    const R_ADMINISTRATOR = 2;
    const R_ADMIN_TU = 3;
    const R_STAF_TU = 4;
    const R_STAF_BIRO = 5;
    const R_PENGELOLA = 6;
    const R_UNIT_KERJA = 7;
    const R_UNIT_PENERIMA = 8;
    const R_USER = 9;

    //put your code here
    public function check() {
        $data = Yii::$app->db->createCommand('SELECT name, name_id FROM auth_item WHERE type=1')->queryAll();
        $data = \yii\helpers\ArrayHelper::map($data, 'name_id', 'name_id');
        $roles = array_values(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

        if (!empty($data)) {
            return $data;
        } else {
            return 'is Guset?';
        }
    }

    public function getRoles() {
        $roles = array_values(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
        $result = [];
        foreach ($roles AS $role) {
            $result[] = $role->data;
        }

        return $result;
    }

}
