<?php

/*
 * haifahrul <haifahrul@gmail.com>
 */

namespace app\modules\admin\components;

class Menus {

    static function getListTab() {
        return [
            'items' => [
                ['label' => 'Bank', 'url' => ['/admin/bank']],
                ['label' => 'Banner', 'url' => ['/admin/banner']],
                ['label' => 'Campaign Kategori', 'url' => ['/admin/campaign-kategori']],
                ['label' => 'Kota / Kabupaten', 'url' => ['/admin/kota-kabupaten']],
                ['label' => 'Provinsi', 'url' => ['/admin/provinsi']],
            ],
            'options' => ['class' => 'nav nav-tabs', 'id' => ''],
            'linkTemplate' => '<a href="{url}" data-pjax=0><span>{label}</span></a>',
            'activeCssClass' => 'active',
            'activateItems' => true,
        ];
    }

}
