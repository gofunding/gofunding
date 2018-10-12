<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = 'Profil';
// $this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => '/dashboard/'];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-view">
    <h1><?php  Html::encode($this->title) ?></h1>

    <div class="panel container">
        <div class="panel-header">
            <h1>
                <?= Html::a(Yii::t('app', 'Update Profil'), ['update', 'id' => $model->user_id], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Ganti Kata Sandi'), ['change-password', 'id' => $model->user_id], ['class' => 'btn btn-success']) ?>
            </h1>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 text-right"></label>
                    <div class="col-sm-10">
                        <div class="text-left">
                            <img height="200" src="<?= Yii::$app->helpers->displayImage('avatar', $model->avatar) ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 text-right">E-mail</label>
                    <div class="col-sm-10">
                        <div class="text-left">
                            <?= Html::encode(empty($model->user->email) ? '-' : $model->user->email) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 text-right">NPM/NIK</label>
                    <div class="col-sm-10">
                        <div class="text-left">
                            <?= Html::encode(empty($model->user->username) ? '-' : $model->user->username) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 text-right">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <div class="text-left">
                            <?= Html::encode(empty($model->nama_lengkap) ? '-' : $model->nama_lengkap) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 text-right">Biodata Singkat</label>
                    <div class="col-sm-10">
                        <div class="text-left">
                            <?= Html::encode(empty($model->bio_singkat) ? '-' : $model->bio_singkat) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 text-right">Nomor Handphone</label>
                    <div class="col-sm-10">
                        <div class="text-left">
                            <?= Html::encode(empty($model->no_telp) ? '-' : $model->no_telp) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 text-right">Lokasi</label>
                    <div class="col-sm-10">
                        <div class="text-left">
                            <?= Html::encode($model->getLokasi()) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>