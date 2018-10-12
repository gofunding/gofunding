<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Donasi;
use app\modules\admin\models\search\DonasiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use app\models\Payment;

/**
 * created haifahrul
 */
class DonasiController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                // Action delete hanya diizinkan post saja 
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new DonasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionApprove($id) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($id);
            if (!empty($model->id)) {
                $modelPayment = new Payment();
                if ($model && $modelPayment->insertIntoDonatur($model)) {
                    $model->status = Donasi::STATUS_SUKSES;

                    // Update donasi dan cek apakah donasi sudah tercapai
                    if ($model->update() && $modelPayment->checkCampaign($model->campaign)) {
                        Yii::$app->session->setFlash('success', 'Pembayaran berhasil diproses dan ditambahkan ke donasi campaign:' . $model->campaign->judul_campaign);
                        $transaction->commit();
                    } else {
                        Yii::$app->session->setFlash('danger', 'Pembayaran gagal diproses. Silahkan hubungi tim IT.');
                        $transaction->rollBack();
                    }
                    
                    return $this->redirect(['index']);
                }
            }
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger', 'Failure, Data failed removed');
        }
        return $this->redirect(['index']);
    }

//    public function actionDelete($id) {
//        $transaction = Yii::$app->db->beginTransaction();
//        try {
//            if ($this->findModel($id)->delete()) {
//                $transaction->commit();
//                Yii::$app->session->setFlash('success', 'Data has been removed!');
//                return $this->redirect(['index']);
//            }
//        } catch (Exception $e) {
//            $transaction->rollback();
//            Yii::$app->session->setFlash('danger', 'Failure, Data failed removed');
//        }
//        return $this->redirect(['index']);
//    }

    protected function findModel($id) {
        if (($model = Donasi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
