<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Yii;
use app\models\Donasi;
use app\models\Campaign;
use app\models\Donatur;

/**
 * Description of Payment
 *
 * @author ahmad
 */
class Payment {

    //put your code here
    public static function setPayment($orderId) {
        try {
            $transaction = Yii::$app->db->beginTransaction();

            $model = self::findModel((int) $orderId);
//            return $model;
//            
////            if ($model )
//            
//            exit;

            if (!empty($model)) {
                $model->status = Donasi::STATUS_SUKSES;
                $modelDonatur = new Donatur();
                $modelDonatur->campaign_id = $model->campaign_id;
                $modelDonatur->user_id = $model->user_id;
                $modelDonatur->donasi_id = $model->id;
                $modelDonatur->nominal_donasi = $model->nominal_donasi;
                $modelDonatur->biaya_administrasi = $model->bank->biaya_per_transaksi;
                $modelDonatur->donasi_bersih = $model->nominal_donasi - $model->bank->biaya_per_transaksi;

                $modelCampaign = self::findModelCampaign($model->campaign_id);
                if (!empty($modelCampaign)) {
                    $modelCampaign->terkumpul += $modelDonatur->donasi_bersih;
                    $modelCampaign->scenario = 'payment';
                    if ($model->update() && $modelDonatur->save() && $modelCampaign->update()) {
                        $transaction->commit();

                        // Cek apakah target donasi sudah terkumpul
                        $modelCampaign->cekIsReached($model->campaign_id);

                        $response = '200';
                    } else {
                        $transaction->rollBack();
                        $response = '500';
                    }
                } else {
                    $response = '400';
                }
            } else {
                $response = '400';
            }

            echo $response;
        } catch (\yii\db\Exception $e) {
            echo '500';
        }
    }

    /**
     * Finds the Donasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Donasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected static function findModel($id) {
        if (($model = Donasi::find()->where(['id' => $id])->andWhere(['status' => Donasi::STATUS_BELUM_DIBAYAR])->one()) !== null) {
            echo $model;
        } else {
            echo '';
        }
    }

    /**
     * Finds the Campaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Donasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    private static function findModelCampaign($id) {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            return '';
        }
    }

    public function insertIntoDonatur($model) {
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

    public function updateCampaignTerkumpul($idCampaign, $nominal) {
        $model = $this->findModelCampaign($idCampaign);
        $danaTerkumpulSekarang = $model->terkumpul;
        $model->terkumpul += $nominal;

        if ((int) $model->terkumpul >= (int) $danaTerkumpulSekarang) {
            $model->is_reached = 1;
        }

        return $model->update();
    }

    public function checkCampaign($campaignId) {
        
        $modelCampaign = $this->findModelCampaign($campaignId);
        
        if ($modelCampaign->cekIsReached($campaignId)) {
            return true;
        } else {
            return false;
        }
    }

}
