<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\dashboard\components;

use Yii;
use yii\helpers\Html;

/**
 * Created by haifahrul.
 * User: haifahrul
 * Date: 2/3/2018
 * Time: 9:47 AM
 */
class Menus {

    public static function getMenuCampaignTab() {
        return [
            'items' => [
                ['label' => 'Overview', 'url' => ['/dashboard/campaign/overview', 'id' => $_GET['id']]],
                ['label' => 'Detail Campaign', 'url' => ['/dashboard/campaign/view', 'id' => $_GET['id']]],
                ['label' => 'List Donatur', 'url' => ['/dashboard/campaign/donatur', 'id' => $_GET['id']]],
                ['label' => 'Donatur Offline', 'url' => ['/dashboard/campaign/donatur-offline', 'id' => $_GET['id']]],
                ['label' => 'Edit Campign', 'url' => ['/dashboard/campaign/update', 'id' => $_GET['id']]],
//                ['label' => 'Verifikasi Rekening', 'url' => ['/dashboard/campaign/verifikasi', 'id' => $_GET['id']]],
                ['label' => 'Carikan Dana', 'url' => ['/dashboard/campaign/pencairan', 'id' => $_GET['id']]],
            ],
            'options' => ['class' => 'nav nav-tabs', 'id' => ''],
            'linkTemplate' => '<a href="{url}" data-pjax=0><span>{label}</span></a>',
            'activeCssClass' => 'active',
            'activateItems' => true,
        ];
    }
}
