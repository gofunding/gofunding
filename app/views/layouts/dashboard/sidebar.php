<?php
use yii\helpers\Url;
use yii\helpers\Html;

$mC = Yii::$app->controller->id;
?>
<br>
<div class="sidebar-dashboard">
    <div class="panel">
        <div class="panel-header">
            <br>
            <div class="text-center">
                <img height="100" class="img-circle" src="<?=Yii::$app->helpers->displayImage('avatar', Yii::$app->user->identity->userProfile->avatar)?>"
            </div>
            <br><br>
            <p><b><?=Yii::$app->user->identity->userProfile->nama_lengkap?></b></p>
            <?=Html::a('Edit Profile', ['/dashboard/profil/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-success'])?>
        </div>
        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation" class="<?= in_array($mC, ['default']) ? 'active' : null ?>">
                    <a href="<?=Url::to('/dashboard/')?>">Overview</a>
                </li>
                <li role="presentation" class="<?= in_array($mC, ['campaign']) ? 'active' : null ?>">
                    <a href="<?=Url::to('/dashboard/campaign/')?>">Campaign Saya</a>
                </li>
                <li role="presentation" class="<?= in_array($mC, ['donasi']) ? 'active' : null ?>">
                    <a href="<?=Url::to('/dashboard/donasi/')?>">Donasi Saya</a>
                </li>
                <li role="presentation" class="<?= in_array($mC, ['profil']) ? 'active' : null ?>">
                    <a href="<?=Url::to('/dashboard/profil/')?>">Akun Saya</a>
                </li>
            </ul>
        </div>
    </div>
</div>
