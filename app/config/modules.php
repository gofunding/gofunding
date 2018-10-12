<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    'admin' => [
        'class' => 'app\modules\admin\Module',
    ],
    'user-management' => [
        'class' => 'app\modules\userManagement\Module',
    ],
    'dashboard' => [
        'class' => 'app\modules\dashboard\Module',
    ],
    'user-role' => [
        'class' => '\hscstudio\mimin\Module',
    ],
    'log' => [
        'class' => 'app\modules\log\Module',
    ],
    // 'gii' => [
    //    'class' => 'yii\gii\Module',
    //    'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*', 'XXX.XXX.XXX.XXX'] // adjust this to your needs
    // ],
    'gridview' => ['class' => 'kartik\grid\Module'],
];
