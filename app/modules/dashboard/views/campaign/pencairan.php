<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */

$this->title = $model['judul_campaign'];
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => '/dashboard/'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaign'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$formatter = Yii::$app->formatter;
?>

<br>
<div class="campaign-view panel panel-body">
    <?= \app\widgets\adminlte\Menu::widget(\app\modules\dashboard\components\Menus::getMenuCampaignTab()); ?>
    <h1 class="text-center"><?= Html::encode($model['judul_campaign']) ?></h1>
</div>

<div class="panel panel-body">
    <div class="row">
        <div class="col-xs-12">
            <div class="text-left">
                <h4><a target="_blank" href="<?= Url::to(['/dashboard/campaign/download-form-pernyataan', 'id' => $model['id']]) ?>">Cetak Surat Pernyataan </a> </h4>
                <p>
                    Silahkan kirimkan biodata Anda dengan format:
                    Nama Anda,
                    Nama Campaign,
                    No KTP/ID,
                    Nomor Rekening Bank,
                    Nama Pemilik Akun Bank,
                    Nama Bank,
                    Nomor HP Anda,
                </p>
                <p>Kirim ke email <?= Yii::$app->params['adminEmail'] ?></p>
                <p>
                    Kami akan melakukan verifikasi terlebih dahulu, dan segera memberitahu Anda jika telah selesai.

                    <br><br>
                    Terima kasih,
                    <br>
                    <br>
                    Salam Hangat, <br>
                    <b><?= Yii::$app->params['brand'] ?></b>
                </p>
            </div>
        </div>
    </div>
</div>