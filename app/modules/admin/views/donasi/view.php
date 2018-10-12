<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Bank;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Donasi */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Donasis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="panel donasi-view">
    <div class="panel-body">
        <h1><?php Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('<i class="fa fa-arrow-left"></i> Kembali', ['index'], ['class' => 'btn btn-default']) ?> &nbsp;
            <?php
            if ($model->status === 4 && $model->bank->nama_payment == 'manual_bank_transfer') {
                echo Html::a('<i class="fa fa-check"></i> Approve Pembayaran', ['approve', 'id' => $model->id], ['class' => 'btn btn-success', 'data' => [
                        'confirm' => 'Apakah Anda yakin akan memproses pembayaran ini?. Jika dilanjutkan nominal donasi tersebut akan ditambahkan ke donasi campaign bersangkutan.',
                        'method' => 'post',
                    ],]);
            }
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
//            'id',
                    [
                    'label' => 'Judul Campaign',
                    'attribute' => 'campaign_id',
                    'value' => $model['campaign']['judul_campaign']
                ],
                    [
                    'label' => 'Nama Donatur',
                    'attribute' => 'user_id',
                    'value' => $model['userProfile']['nama_lengkap']
                ],
                'nominal_donasi:currency',
                'tanggal_donasi:datetime',
                    [
                    'label' => 'Status Pembayaran',
                    'attribute' => 'bank_id',
                    'value' => app\models\Donasi::getStatus($model['status'])
                ],
                'komentar',
//            'phone_penerima_sms',
                [
                    'label' => 'Metode Pembayaran',
                    'attribute' => 'bank_id',
                    'value' => $model['bank']['nama_bank'] . Bank::getVaNumber($model['bank']['va_number']),
                ],
                'transfer_sebelum:datetime',
//            'signature_key:ntext',
//            'created_at',
//            'updated_at',
//            'created_by',
//            'updated_by',
//            'order_id',
//            'kode_unik',
                [
                    'label' => 'Bukti Pembayaran',
                    'attribute' => 'upload_bukti_transaksi',
                    'format' => 'raw',
                    'value' => '<a target="_blank" href="' . Url::to(Yii::$app->params['uploadUrl']) . 'bukti_transaksi/' . $model['upload_bukti_transaksi'] . '">Lihat file</a>'
                ],
            ],
        ])
        ?>
    </div>
</div>