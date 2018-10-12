<?php
require_once(Yii::getAlias('@veritrans'));

Veritrans_Config::$isProduction = Yii::$app->params['isProduction'];
Veritrans_Config::$serverKey = Yii::$app->params['serverKey'];

$notif = new Veritrans_Notification();
$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;

if ($transaction == 'capture') {
    // For credit card transaction, we need to check whether transaction is challenge by FDS or not
    if ($type == 'credit_card') {
        if ($fraud == 'challenge') {
            // TODO set payment status in merchant's database to 'Challenge by FDS'
            // TODO merchant should decide whether this transaction is authorized or not in MAP
            echo "Transaction order_id: " . $order_id . " is challenged by FDS";
        } else {
            // TODO set payment status in merchant's database to 'Success'
            echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;

//            try {
//                $transaction = Yii::$app->db->beginTransaction();
//                $model = $this->findModel($id);
//                $model->status = Donasi::STATUS_SUKSES;
//                $modelDonatur = new Donatur();
//                $modelDonatur->campaign_id = $model->campaign_id;
//                $modelDonatur->user_id = $model->user_id;
//                $modelDonatur->donasi_id = $model->id;
//                $modelDonatur->nominal_donasi = $model->nominal_donasi;
//                $modelDonatur->biaya_administrasi = $model->bank->biaya_per_transaksi;
//                $modelDonatur->donasi_bersih = $model->nominal_donasi - $model->bank->biaya_per_transaksi;
//
//                $modelCampaign = $this->findModelCampaign($model->campaign_id);
//                $modelCampaign->terkumpul += $modelDonatur->donasi_bersih;
//                $modelCampaign->scenario = 'payment';
//
//                if ($model->update() && $modelDonatur->save() && $modelCampaign->update()) {
//                    $transaction->commit();
//                    $response = 'success';
//                } else {
//                    $transaction->rollBack();
//                    $response = 'failed';
//                }
//
//                return $this->render('finish', ['response' => $response]);
//            } catch (\yii\db\Exception $e) {
//                
//            }
        }
    }
} else if ($transaction == 'settlement') {
    // TODO set payment status in merchant's database to 'Settlement'
    echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
} else if ($transaction == 'pending') {
    // TODO set payment status in merchant's database to 'Pending'
    echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
} else if ($transaction == 'deny') {
    // TODO set payment status in merchant's database to 'Denied'
    echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
} else if ($transaction == 'expire') {
    // TODO set payment status in merchant's database to 'expire'
    echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
} else if ($transaction == 'cancel') {
    // TODO set payment status in merchant's database to 'Denied'
    echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
}

?>