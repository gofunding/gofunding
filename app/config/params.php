<?php

return [
    'brand' => 'Go Funding',
    'adminEmail' => '',
    // Storage
    'uploadPath' => Yii::getAlias('@web') . '/uploads/',
    // URL
    'uploadUrl' => Yii::setAlias('@uploadsUrl', '/') . '/public/uploads/',
    'defaultImage' => Yii::setAlias('@defaultImage', '/') . '/public/images/no-images.png',
    'favicon' => Yii::setAlias('@defaultImage', '/') . '/public/images/favicon.ico',
    'id-ID' => Yii::setAlias('@defaultImage', '/') . '/public/images/flags/Indonesia-16.png',
    'en-US' => Yii::setAlias('@defaultImage', '/') . '/public/images/flags/United-Kingdom-16.png',
    'publicUrl' => Yii::setAlias('@publicUrl', '/public') . '/public/',
    'campaignImage' => Yii::setAlias('@publicUrl', '/public') . '/public/uploads/campaign/',
    'nameDatabase' => 'gofunding',
    'biaya_operasional' => 5, // dalam bilangan persentase
    // Configuration Midtrans
    'isProduction' => false, // set true for production environment
    // 'isSanitized' => true,
    // 'is3ds' => false,
    // SANDBOX
    'midtransSource' => 'https://app.sandbox.midtrans.com/snap/snap.j', // Sandbox
    'serverKey' => 'SB-Mid-server-UDSx--_DSqHtpKxWZyNA4Fe3', // Sandbox
    'clientKey' => 'SB-Mid-client-GWNC_eD08atvcxXh', // Sandbox
        // PRODUCTION
        // 'midtransSource' => 'https://app.midtrans.com/snap/snap.j',
        // 'serverKey' => 'Mid-server-_SmI110tfHqnBNTAHI5vqw5R',
        // 'clientKey' => 'Mid-client-lBBTvdwTV3zkHECY', 
];
