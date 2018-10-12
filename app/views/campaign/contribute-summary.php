<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\NotFoundHttpException;

$formatter = Yii::$app->formatter;

require_once(Yii::getAlias('@veritrans'));

//Set Your server key
Veritrans_Config::$serverKey = Yii::$app->params['serverKey'];
Veritrans_Config::$isProduction = Yii::$app->params['isProduction'];
// Veritrans_Config::$isSanitized = Yii::$app->params['isSanitized'];
// Veritrans_Config::$is3ds = Yii::$app->params['is3ds'];
// Fill transaction details
$transaction_details = [
    'order_id' => $orderId,
//    'order_id' => rand(),
    'gross_amount' => $total, // no decimal allowed
];

$customer_details = [
    'first_name' => Yii::$app->user->identity->userProfile->nama_lengkap, //optional
    'last_name' => "", //optional
    'email' => Yii::$app->user->identity->email, //mandatory
    'phone' => $phonePenerimaSms, //mandatory
];

$item1_details = [
    'id' => '1',
    'price' => $model->nominal_donasi,
    'quantity' => 1,
    'name' => $judulCampaign
];
$item2_details = [
    'id' => '2',
    'price' => $biayaPerTransaksi,
    'quantity' => 1,
    'name' => 'Biaya Per Transaksi Midtrans'
];
$item_details = array($item1_details, $item2_details);

$expiry = [
    "start_time" => $model->tanggal_donasi . " +0700",
    "unit" => "day",
    "duration" => 1
];

// Fill transaction details
$transaction = [
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'enabled_payments' => [$enablePayments],
    'item_details' => $item_details,
    'expiry' => $expiry
];

try {
    $snapToken = Veritrans_Snap::getSnapToken($transaction);
} catch (Exception $e) {
    
    echo '<script>window.location="'.Yii::$app->request->referrer.'"; window.close()</script>';
    exit;
}

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
                                        <h4>Biaya Administrasi Midtrans</h4>
                                    </td>
                                    <td style='border:none;'>
                                        <h4 class="text-right">
                                            <?= $formatter->asCurrency($biayaPerTransaksi) ?>
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
                        <div id="pay-button" class="btn btn-success btn-block">
                            <b>Bayar Sekarang</b>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <p>
                        <i>Seluruh transaksi akan diproses oleh
                            <a href='https://midtrans.com/' target='_blank'>Midtrans</a>. Klik tombol diatas untuk lanjut ke halaman pembayaran kartu kredit.</i>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

<!-- TODO: Remove ".sandbox" from script src URL for production environment.
Also input your client key in "data-client-key" -->
<script src="<?= Yii::$app->params['midtransSource'] ?>s" data-client-key="<?= Yii::$app->params['clientKey'] ?>"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        // SnapToken acquired from previous step
        snap.pay('<?= $snapToken ?>', {
            // Optional
            onSuccess: function (result) {
                /* You may add your own js here, this is just example */
                $.ajax({
                    url: "<?= \yii\helpers\Url::to(['/payment/finish']) ?>",
                    type: "POST",
                    data: result,
                    success: function (data) {
                        if (data == 200) {
                            document.getElementById('result-json').innerHTML = '<div class="result-json-success">Pembayaran anda berhasil. Terimakasih telah berpartisipasi.</div>';
                            document.getElementById('result-json').innerHTML += '<a href="/campaign/index"><div class="btn btn-primary">Kembali ke Donasi</div></a><br><br>';
                        } else if (data === 400) {
                            document.getElementById('result-json').innerHTML = '<div class="result-json-error">Error 400. Data tidak ditemukan.</div>';
                            document.getElementById('result-json').innerHTML += '<a href="/campaign/index"><div class="btn btn-primary">Kembali ke Donasi</div></a><br><br>';
                        } else if (data === 500) {
                            // document.getElementById('result-json').innerHTML = '<div class="result-json-error">Error 500. Terjadi kesalahan, silahkan hubungi admin atau cek status donasi Anda di menu</div>';
                            document.getElementById('result-json').innerHTML = '<div class="result-json-error">Terjadi kesalahan, silahkan cek donasi Anda di menu <a href="/dashboard/donasi/">Dashboard > Donasi</a> atau hubungi admin Yarsi Peduli</div>';
                            document.getElementById('result-json').innerHTML += '<a href="/campaign/index"><div class="btn btn-primary">Kembali ke Donasi</div></a><br><br>';
                        }
                    },
                    error: function (data) {
                        // document.getElementById('result-json').innerHTML = '<div class="result-json-error">Terjadi kesalahan, silahkan hubungi Admin jika Anda sudah melakukan pembayaran.</div>';
                        document.getElementById('result-json').innerHTML = '<div class="result-json-error">Terjadi kesalahan, silahkan cek donasi Anda di menu <a href="/dashboard/donasi/">Dashboard > Donasi</a> atau hubungi Admin jika Anda sudah melakukan pembayaran.</div>';
                        document.getElementById('result-json').innerHTML += '<a href="/campaign/index"><div class="btn btn-primary">Kembali ke Donasi</div></a><br><br>';
                    }
                });
            },
            // Optional
            onPending: function (result) {
                /* You may add your own js here, this is just example */
//                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                $.ajax({
                    url: "<?= \yii\helpers\Url::to(['/payment/finish']) ?>",
                    type: "POST",
                    data: result,
                    success: function (data) {
                        if (data == 201) {
                            document.getElementById('result-json').innerHTML = '<div class="result-json-warning">Transaksi anda sedang dalam proses. Terimakasih telah berpartisipasi</div>';
                            document.getElementById('result-json').innerHTML += '<a href="/campaign/index"><div class="btn btn-primary">Kembali ke Donasi</div></a><br><br>';
                        } else if (data === 400) {
                            document.getElementById('result-json').innerHTML = '<div class="result-json-error">Error 400. Data tidak ditemukan.</div>';
                            document.getElementById('result-json').innerHTML += '<a href="/campaign/index"><div class="btn btn-primary">Kembali ke Donasi</div></a><br><br>';
                        } else if (data === 500) {
                            document.getElementById('result-json').innerHTML = '<div class="result-json-error">Terjadi kesalahan, silahkan cek donasi Anda di menu <a href="/dashboard/donasi/">Dashboard > Donasi</a> atau hubungi admin Yarsi Peduli</div>';
                            document.getElementById('result-json').innerHTML += '<a href="/campaign/index"><div class="btn btn-primary">Kembali ke Donasi</div></a><br><br>';
                        }
                    },
                    error: function (data) {
                        document.getElementById('result-json').innerHTML = '<div class="result-json-error">Terjadi kesalahan, silahkan cek donasi Anda di menu <a href="/dashboard/donasi/">Dashboard > Donasi</a> atau hubungi admin Yarsi Peduli</div>';
                        document.getElementById('result-json').innerHTML += '<a href="/campaign/index"><div class="btn btn-primary">Kembali ke Donasi</div></a><br><br>';
                    }
                });
            },
//             Optional
            onError: function (result) {
                /* You may add your own js here, this is just example */
//                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                document.getElementById('result-json').innerHTML = '<div class="result-json-error">Terjadi kesalahan, silahkan cek donasi Anda di menu <a href="/dashboard/donasi/">Dashboard > Donasi</a> atau hubungi admin Yarsi Peduli</div>';
                document.getElementById('result-json').innerHTML += '<a href="/campaign/index"><div class="btn btn-primary">Kembali ke Donasi</div></a><br><br>';
            }
        });
    };
</script>