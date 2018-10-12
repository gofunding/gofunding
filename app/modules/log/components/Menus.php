<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\log\components;

/**
 * Description of Menus
 *
 * @author haifahrul
 */
class Menus {

    //put your code here
    static function getMenuTab() {

        $items[] = ['label' => 'Login', 'url' => ['/log/login']];

        if (\Yii::$app->user->can('Super User') || \Yii::$app->user->can('Administrator')) {
            $items[] = ['label' => 'Lihat', 'url' => ['/log/view']];
            $items[] = ['label' => 'Tambah', 'url' => ['/log/create']];
            $items[] = ['label' => 'Perbaharui', 'url' => ['/log/update']];
            $items[] = ['label' => 'Hapus', 'url' => ['/log/delete']];
            $items[] = ['label' => 'Cetak', 'url' => ['/log/print']];
            $items[] = ['label' => 'Download', 'url' => ['/log/download']];
        }

        if (\Yii::$app->user->can('Super User')) {
            $items[] = ['label' => 'SQL Error', 'url' => ['/log/sql-error']];
        }

        return [
            'items' => $items,
            'options' => ['class' => 'nav nav-tabs', 'id' => ''],
            'linkTemplate' => '<a href="{url}" data-pjax=0><span>{label}</span></a>',
            'activeCssClass' => 'active',
            'activateItems' => true,
        ];
    }

}
