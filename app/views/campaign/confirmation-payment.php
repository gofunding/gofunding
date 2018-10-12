<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\NotFoundHttpException;

$formatter = Yii::$app->formatter;
?>

<style>
    .result-json-error {
        padding: 10px;
        background: #d9534f;
        color: #fff;
        margin: 20px;
        font-size: 20px
    }

    .result-json-success {
        padding: 10px;
        background: #5bbd6e;
        color: #fff;
        margin: 20px;
        font-size: 20px
    }

    .result-json-warning {
        padding: 10px;
        background: #ffc107;
        color: #fff;
        margin: 20px;
        font-size: 20px
    }
</style>

<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <h2>Konfirmasi Donasi</h2>
                <h4>
                    <b>
                        <?= $judulCampaign ?>
                    </b>
                </h4>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel">
                <div class="panel-body text-center">
                    <table class="table borderless table-borderless table-condensed">
                        <tbody>
                            <tr>
                                <td>Nominal Donasi</td>
                                <td> <?= $formatter->asCurrency($model->nominal_donasi) ?></td>
                            </tr>
                            <tr>
                                <td>Metode Pembayaran</td>
                                <td><?= $model->bank->nama_bank ?></td>
                            </tr>
                            <tr>
                                <td>Nomor Rekening</td>
                                <td><?= $vaNumber ?></td>
                            </tr>
                            <tr>
                                <td>Nama Penerima</td>
                                <td><?= $receiver ?></td>
                            </tr>
                            <tr>
                                <td> Total </td>
                                <td><?= $formatter->asCurrency($total) ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <h4>
                        Silahkan upload bukti transaksi
                    </h4>
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                       <?= $form->field($uploadForm, 'file')->fileInput()->label(false) ?>
                    <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>