<?php

namespace app\controllers;

use Yii;
//use yii\web\Controller;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Donasi;
use app\models\Donatur;
use app\models\Campaign;
use app\models\Payment;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends \yii\rest\ActiveController {

    public $modelClass = 'app\models\Donasi';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'finish' => ['POST'],
                    'unfinish' => ['POST'],
                    'error' => ['POST'],
                    'notification' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * function_description.
     *
     * @param int|null post
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionNotification() {
        $data = Yii::$app->getRequest()->getBodyParams();

        Yii::$app->db->createCommand('INSERT INTO history_midtrans (response) VALUE (:response)')->bindValue(':response', json_encode($data))->execute();

        $transaction = $data['transaction_status'];
        $type = $data['payment_type'];
        $fraud = $data['fraud_status'];
        $statusCode = $data['status_code'];
        $orderId = $data['order_id'];
        $signatureKey = $data['signature_key'];

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
//                    echo "Transaction order_id: " . $orderId . " is challenged by FDS";
                } elseif ($fraud == 'accept' && $statusCode = '200') {
                    // TODO set payment status in merchant's database to 'Success'
//                    echo "Transaction order_id: " . $orderId . " successfully captured using " . $type;
//                    return $orderId;
//                    $this->setPayment($orderId);
                    Payment::setPayment($orderId);
                }
            } elseif ($statusCode == '200') {
                Payment::setPayment($orderId);
//                $this->setPayment($orderId);
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
//            echo "Transaction order_id: " . $orderId . " successfully transfered using " . $type;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
//            echo "Waiting customer to finish transaction order_id: " . $orderId . " using " . $type;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
//            echo "Payment using " . $type . " for transaction order_id: " . $orderId . " is denied.";
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
//            echo "Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.";
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
//            echo "Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.";
        }
//        return $this->render('notification');
    }

    protected function setPayment($orderId) {
        return Yii::$app->getRequest()->getBodyParams();
    }

    public function actionFinish() {
        // Using Credit Card
        try {
            if (!empty($_POST['status_code']) && ($_POST['status_code'] == 200)) {
                try {
                    $transaction = Yii::$app->db->beginTransaction();
                    $model = $this->findModel($_POST['order_id']);

                    if ($model && $this->insertIntoDonatur($model)) {
                        $model->status = Donasi::STATUS_SUKSES;

                        if ($model->update()) {
                            $transaction->commit();

                            // Cek apakah donasi sudah tercapai
                            $modelCampaign = $this->findModelCampaign($model->campaign_id);
                            $modelCampaign->cekIsReached($model->campaign_id);

                            $response = 200;
                        } else {
                            $transaction->rollBack();
                            $response = 400;
                        }
                        return json_encode($response);
                    } else {
                        return json_encode(400);
                    }
                } catch (\yii\db\Exception $e) {
                    $transaction->rollBack();
                    return json_encode(500);
                }
            } elseif (!empty($_POST) && ($_POST['status_code'] == 201)) {
                /* Using Bank Transfer
                 * Pending */
                try {
                    $transaction = Yii::$app->db->beginTransaction();
                    $model = $this->findModel($_POST['order_id']);

                    if ($model && $this->insertIntoDonatur($model)) {
                        $model->status = Donasi::STATUS_MENUNGGU_VERIFIKASI;

                        if ($model->update()) {
                            $transaction->commit();
                            $response = 201;
                        } else {
                            $transaction->rollBack();
                            $response = 400;
                        }
                        return json_encode($response);
                    } else {
                        return json_encode(400);
                    }
                } catch (\yii\db\Exception $e) {
                    $transaction->rollBack();
                    return json_encode(500);
                }
            }
        } catch (yii\web\Exception $e) {
            echo 'as';
        }
    }

    public function actionUnfinish() {
        if (($id = $_GET['order_id']) !== null && ($status_code = $_GET['status_code']) !== null && ($transaction_status = $_GET['transaction_status']) !== null) {

            try {
                $transaction = Yii::$app->db->beginTransaction();
                $model = $this->findModel($id);
                $model->status = Donasi::STATUS_BELUM_DIBAYAR;

                if ($model->update()) {
                    $transaction->commit();
                    $response = 'success';
                } else {
                    $transaction->rollBack();
                    $response = 'failed';
                }

                return $this->render('unfinish', ['response' => $response]);
            } catch (\yii\db\Exception $e) {
                
            }
        } else {
            return $this->redirect(['/site/error']);
        }
    }

    public function actionError() {
        if (($id = $_GET['order_id']) !== null && ($status_code = $_GET['status_code']) !== null && ($transaction_status = $_GET['transaction_status']) !== null) {

            try {
                $transaction = Yii::$app->db->beginTransaction();
                $model = $this->findModel($id);
                $model->status = Donasi::STATUS_GAGAL;

                if ($model->update()) {
                    $transaction->commit();
                    $response = 'success';
                } else {
                    $transaction->rollBack();
                    $response = 'failed';
                }

                return $this->render('error', ['response' => $response]);
            } catch (\yii\db\Exception $e) {
                
            }
        } else {
            return $this->redirect(['/site/error']);
        }
    }

    protected function insertIntoDonatur($model) {
        $transaction = Yii::$app->db->beginTransaction();

        $modelDonatur = new Donatur();
        $modelDonatur->campaign_id = $model->campaign_id;
        $modelDonatur->user_id = $model->user_id;
        $modelDonatur->donasi_id = $model->id;
        $modelDonatur->nominal_donasi = $model->nominal_donasi;
        $modelDonatur->biaya_administrasi = $model->bank->biaya_per_transaksi;
        $modelDonatur->donasi_bersih = (int) $model->nominal_donasi - (int) $model->bank->biaya_per_transaksi;

        $modelCampaign = $this->updateCampaignTerkumpul($model->campaign_id, $modelDonatur->donasi_bersih);

        if ($modelCampaign && $modelDonatur->save()) {
            $transaction->commit();
            $result = true;
        } else {
            $transaction->rollBack();
            $result = false;
        }

        return $result;
    }

    protected function updateCampaignTerkumpul($idCampaign, $nominal) {
        $model = $this->findModelCampaign($idCampaign);
        $danaTerkumpulSekarang = $model->terkumpul;
        $model->terkumpul += $nominal;

        if ((int) $model->terkumpul >= (int) $danaTerkumpulSekarang) {
            $model->is_reached = 1;
        }

        return $model->update();
    }

    /**
     * Finds the Donasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Donasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Donasi::find()->where(['id' => $id])->andWhere(['status' => Donasi::STATUS_BELUM_DIBAYAR])->one()) !== null) {
            return $model;
        } else {
            return '400';
        }
    }

    /**
     * Finds the Campaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Donasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelCampaign($id) {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            return '400';
        }
    }

}
