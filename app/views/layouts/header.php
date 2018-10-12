<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use hscstudio\mimin\components\Mimin;
?>

<?php

NavBar::begin([
    'brandLabel' => '<img src=' . Yii::$app->params["publicUrl"] . 'images/icon.png><div class="navbar-title">' . Yii::$app->params['brand'] . '</div>',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-default navbar-fixed-top',
    ],
]);

if (Yii::$app->user->can('User') || Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Galang Dana', 'url' => Url::to(['/site/buat-campaign'])];
    $menuItems[] = ['label' => 'Donasi', 'url' => Url::to(['/campaign/index'])];
}

if (Yii::$app->user->isGuest) {
    $menuItems[] = [
        'label' => '<div class="fa fa-bars"></div>',
        'url' => '#',
        'items' => [
            ['label' => 'Masuk', 'url' => Url::to(['/site/login'])],
            '<li class="divider"></li>',
            ['label' => 'Daftar', 'url' => Url::to(['/site/signup'])],
            '<li class="divider"></li>',
            ['label' => 'Bantuan', 'url' => Url::to(['/site/faq'])],
        ],
    ];
}

if (Yii::$app->user->can('Super Admin')) {
    $menuItems[] = [
        'label' => 'Pengaturan',
        'url' => '#',
        'items' => [
            ['label' => 'Role', 'url' => Url::to(['/user-role/role'])],
            ['label' => 'User', 'url' => Url::to(['/user-role/user'])],
            ['label' => 'Route', 'url' => Url::to(['/user-role/route'])],
        ],
    ];
    // $menuItems[] = ['label' => 'Keluar', 'url' =>  Url::to(['/site/logout']), 'linkOptions' => ['data-method' => 'post']];
}

if (Yii::$app->user->can('Super Admin') || Yii::$app->user->can('Admin')) {
    // $menuItems[] = [
    //     'label' => 'Pengaturan Admin', 
    //     'url' => '#',
    //     'items' => [
    //         ['label' => 'Data Master', 'url' =>  Url::to(['/admin/bank'])],
    //         ['label' => 'Kelola Campaign', 'url' =>  Url::to(['/admin/campaign'])],
    //     ],
    // ];
    $menuItems[] = ['label' => 'Data Master', 'url' => Url::to(['/admin/bank'])];
    $menuItems[] = ['label' => 'Kelola Campaign', 'url' => Url::to(['/admin/campaign'])];
    $menuItems[] = ['label' => 'Pembayaran Donasi', 'url' => Url::to(['/admin/donasi'])];
    $menuItems[] = ['label' => 'Keluar', 'url' => Url::to(['/site/logout']), 'linkOptions' => ['data-method' => 'post']];
}

if (Yii::$app->user->can('User')) {
    $menuItems[] = [
        'label' => '<div class="fa fa-bars"></div>',
        'url' => '#',
        'items' => [
            ['label' => 'Dashboard', 'url' => Url::to('/dashboard/')],
            '<li class="divider"></li>',
            ['label' => 'Update Profil', 'url' => Url::to(['/dashboard/profil/update', 'id' => Yii::$app->user->id])],
            '<li class="divider"></li>',
            ['label' => 'Donasi', 'url' => Url::to(['/campaign/index'])],
            '<li class="divider"></li>',
            ['label' => 'Buat Campaign', 'url' => Url::to(['/site/buat-campaign'])],
            '<li class="divider"></li>',
            ['label' => 'Keluar', 'url' => Url::to(['/site/logout']), 'linkOptions' => ['data-method' => 'post']]
        ],
    ];
}

// $menuItems = Mimin::filterMenu($menuItems);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
    'encodeLabels' => false
]);
NavBar::end();
?>