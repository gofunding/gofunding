<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

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
                <h4>Kamu akan berdonasi untuk campaign</h4>
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
                    <div id="result-json">
                        <table class="table borderless">
                            <tbody>
                                <tr>
                                    <td style='border:none;'>
                                        <h4>Nominal Donasi</h4>
                                    </td>
                                    <td style='border:none;'>
                                        <h4 class="text-right">
                                            <?= $formatter->asCurrency($model->nominal_donasi) ?>
                                        </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='border:none;'>
                                        <h4>Metode Pembayaran</h4>
                                    </td>
                                    <td style='border:none;'>
                                        <h4 class="text-right">
                                            <?= $model->bank->nama_bank ?>
                                        </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td style='border:none;'>
                                        <h3>Total</h3>
                                    </td>
                                    <td style='border:none;'>
                                        <h3 class="text-right">
                                            <?= $formatter->asCurrency($total) ?>
                                        </h3>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    <h4>
                        Silahkan transfer nominal tersebut ke 
                    </h4>
                    <table>
                        <tbody>
                            <tr>
                                <td>Nomor Rekening</td>
                                <td>:</td>
                                <td><?= $vaNumber ?></td>
                            </tr>
                            <tr>
                                <td>Nama Penerima</td>
                                <td>:</td>
                                <td><?= $receiver ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <p>Kemudian upload bukti pembayaran dimenu <a href="<?= Url::to(['confirmation-payment', 'id' => $_GET['id'], 'campaignId' => $_GET['campaignId']]) ?>">konfirmasi donasi</a></p>
                </div>
            </div>
        </div>
    </div>
</div>