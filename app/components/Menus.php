<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: haifahrul
 * Date: 6/27/2016
 * Time: 9:47 AM
 */
class Menus {

    public static function getMenuProfileTab() {
        return [
            'items' => [
                ['label' => 'Profil', 'url' => ['/profile/index']],
                ['label' => 'Ganti Password', 'url' => ['/profile/change-password']],
            ],
            'options' => ['class' => 'nav nav-tabs', 'id' => ''],
            'linkTemplate' => '<a href="{url}" data-pjax=0><span>{label}</span></a>',
            'activeCssClass' => 'active',
            'activateItems' => true,
        ];
    }
}
