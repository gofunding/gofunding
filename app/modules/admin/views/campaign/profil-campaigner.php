<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */

$this->title = 'Profil Campaigner';
$this->params['breadcrumbs'][] = 'Admin';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kelola Campaign'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$formatter = Yii::$app->formatter;

?>

<div class="campaign-view">

    <div class="panel">
        <div class="panel-body">
            <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> ' . Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-default']) ?> &nbsp
            <?php // Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> &nbsp
            <?php /* Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
              'class' => 'btn btn-danger',
              'data' => [
              'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
              'method' => 'post',
              ],
              ]) */ ?>
        </div>
    </div>

    <div class="user-profile-view">
        <h1><?php Html::encode($this->title) ?></h1>

        <div class="panel container">
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
</div>
