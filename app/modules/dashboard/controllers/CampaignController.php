<?php
namespace app\modules\dashboard\controllers;

use app\models\Campaign;
use app\models\UserProfile;
use app\models\DonaturOffline;
use app\modules\dashboard\models\search\CampaignSearch;
use app\modules\dashboard\models\search\DonaturSearch;
use app\modules\dashboard\models\search\DonaturOfflineSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * created haifahrul <haifahrul@gmail.com>
 */
class CampaignController extends Controller
{

    public function behaviors()
    {
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

    public function beforeAction($action)
    {
        $this->layout = '/dashboard/main';
        if (($action->id == 'view' || $action->id == 'update') && $id = $_GET['id']) {
            $model = $this->findModel($id);

            if (Yii::$app->user->id == $model->user_id) {
                return parent::beforeAction($action);
            }

            return $this->redirect('/error');
        }

        return parent::beforeAction($action);
    }

    public function actionOverview($id)
    {
        $model = Yii::$app->db->createCommand('SELECT c.judul_campaign, 
count(d.id) + (SELECT count(id) FROM donatur_offline WHERE campaign_id = :id) AS total_donatur, 
SUM(d.donasi_bersih) AS total_donasi_online,
(SELECT SUM(dof.nominal_donasi) FROM donatur_offline as dof WHERE campaign_id = :id) AS total_donasi_offline,
c.terkumpul AS total_donasi_terkumpul
FROM campaign c 
JOIN donatur d ON d.campaign_id = c.id
WHERE c.id=:id AND c.`user_id`=:user_id')->bindValues(['id' => $id, 'user_id' => Yii::$app->user->id])->queryOne();

        $biayaAdministrasi = ($model['total_donasi_online'] * Yii::$app->params['biaya_operasional']) / 100;
        $totalDonasiOnline = $model['total_donasi_online'] - $biayaAdministrasi;
        $totalDonasiBersih = $totalDonasiOnline + $model['total_donasi_offline'];

        if (empty($model['judul_campaign'])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('overview', [
                'model' => $model,
                'biayaAdministrasi' => $biayaAdministrasi,
                'totalDonasiBersih' => $totalDonasiBersih
        ]);
    }

    public function actionDonatur($id)
    {
        $dataCampaign = $this->findModelCampaign($id);
        $searchModel = new DonaturSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('donatur', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'judulCampaign' => $dataCampaign->judul_campaign
        ]);
    }

    public function actionDonaturOffline($id)
    {
        $dataCampaign = $this->findModelCampaign($id);
        $searchModel = new DonaturOfflineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('donatur-offline-index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'judulCampaign' => $dataCampaign->judul_campaign
        ]);
    }

    public function actionDonaturOfflineCreate($id)
    {
        $dataCampaign = $this->findModelCampaign($id);
        $model = new DonaturOffline();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();

            $model->campaign_id = $id;
            $model->user_id = Yii::$app->user->id;
            $saldo = $model->nominal_donasi + $dataCampaign->terkumpul;

            $updateDonasiTerkumpul = Yii::$app->db->createCommand()->update('campaign', ['terkumpul' => $saldo], 'id=:id')->bindValue(':id', $id)->execute();

            if ($model->save()) {
                $transaction->commit();

                // Check, whether campaign target_donasi is_reached.
                $dataCampaign->cekIsReached($id);

                Yii::$app->session->setFlash('success', ' Data has been saved!');

                return $this->redirect(['/dashboard/campaign/donatur-offline', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('danger', 'Data gagal disimpan');
                $transaction->rollBack();
            }
        }

        return $this->render('donatur-offline-create', [
                'model' => $model,
                'judulCampaign' => $dataCampaign->judul_campaign
        ]);
    }

    public function actionDonaturOfflineUpdate($id, $d)
    {
        $dataCampaign = $this->findModelCampaign($id);
        $model = $this->findModelDonaturOffline($d);
        $oldTerkumpul = $dataCampaign->terkumpul - $model->nominal_donasi;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();

            $model->campaign_id = $id;
            $model->user_id = Yii::$app->user->id;
            $saldo = $model->nominal_donasi + $oldTerkumpul;

            $updateDonasiTerkumpul = Yii::$app->db->createCommand()->update('campaign', ['terkumpul' => $saldo], 'id=:id')->bindValue(':id', $id)->execute();

            if ($model->save()) {
                $transaction->commit();

                // Check, whether campaign target_donasi is_reached.
                $dataCampaign->cekIsReached($id);

                Yii::$app->session->setFlash('success', ' Data has been saved!');

                return $this->redirect(['/dashboard/campaign/donatur-offline', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('danger', 'Data gagal disimpan');
                $transaction->rollBack();
            }
        }

        return $this->render('donatur-offline-create', [
                'model' => $model,
                'judulCampaign' => $dataCampaign->judul_campaign
        ]);
    }

    public function actionDonaturOfflineDelete($id, $d)
    {
        $model = $this->findModelDonaturOffline($d);
        $dataCampaign = $this->findModelCampaign($id);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $dataCampaign->terkumpul = $dataCampaign->terkumpul - $model->nominal_donasi;

            if ($model->delete() && $dataCampaign->update()) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Data has been removed!');

                // Check, whether campaign target_donasi is_reached.
                $dataCampaign->cekIsReached($id);

                return $this->redirect(['/dashboard/campaign/donatur-offline', 'id' => $id]);
            }
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger', 'Failure, Data failed removed');

            return $this->redirect(['/dashboard/campaign/donatur-offline', 'id' => $id]);
        }
    }

    public function actionIndex()
    {
        $searchModel = new CampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->id == $model->user_id) {
            $date1 = date_create($model->deadline);
            $date2 = date_create(date('Y-m-d'));
            $diff = date_diff($date1, $date2);
            $model->deadline = $diff->format("%a");

            $jumlahDonatur = Yii::$app->db->createCommand('SELECT id FROM donasi WHERE campaign_id=:id AND `status` = 2 LIMIT 5')->bindValue(':id', $id)->queryAll();
            $donatur = Yii::$app->db->createCommand('SELECT up.nama_lengkap, donasi.* FROM donasi LEFT JOIN user_profile up ON  up.user_id = donasi.user_id WHERE campaign_id=:id AND `status` = 2 LIMIT 5')->bindValue(':id', $id)->queryAll();

            return $this->render('view', [
                    'model' => $model,
                    'donatur' => $donatur,
                    'jumlahDonatur' => count($jumlahDonatur)
            ]);
        } else {
            Yii::$app->session->setFlash('warning', 'Campaign tidak tersedia');
            return $this->redirect('index');
        }
    }

    public function actionUpdate($id)
    {
        // $this->layout = '/dashboard/main';
        $userId = Yii::$app->user->id;
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $modelProfile = UserProfile::findOne($userId);
        $modelProfile->scenario = 'campaign-create-form-step-3';
        $model->deadline = date('d-m-Y', strtotime($model->deadline));

//        if ($model->load(Yii::$app->request->post()) && $modelProfile->load(Yii::$app->request->post())) {
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            $model->user_id = $userId;
            $model->deadline = date('Y-m-d', strtotime($model->deadline));
//            $model->is_active = 5; // Review
//            $model->is_agree = 1;

            if ($model->target_donasi > $model->terkumpul) {
                $model->is_reached = 2;
            } else if ($model->target_donasi <= $model->terkumpul) {
                $model->is_reached = 1;
            }

            $image_file = UploadedFile::getInstance($model, 'cover_image');

            if (!empty($image_file)) {
                $model->cover_image = sha1(Yii::$app->user->id . $image_file->baseName . microtime()) . '.' . $image_file->extension;
                $upload = true;
            } else {
                $upload = false;
            }

//            if ($model->save() && $modelProfile->save() && $model->validate() && $modelProfile->validate()) {
            if ($model->save() && $model->validate()) {
                $transaction->commit();

                // Check, whether campaign target_donasi is_reached.
                $model->cekIsReached($id);

                if ($upload) {
                    $image_file->saveAs(Yii::$app->params['uploadPath'] . 'campaign/' . $model->cover_image);
                }
                Yii::$app->session->setFlash('success', ' Data telah disimpan!');

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger', ' Data gagal disimpan! Silahkan cek form Anda.');
            }
        }

        return $this->render('update', [
                'model' => $model,
                'modelProfile' => $modelProfile,
        ]);
    }

    public function actionPencairan($id)
    {
        // $this->layout = '/dashboard/main';
        // $model = Yii::$app->db->createCommand('SELECT judul_campaign, count(d.id) AS total_donatur, SUM(donasi_bersih) AS total_donasi_terkumpul FROM donatur d LEFT JOIN campaign c ON c.id = d.campaign_id WHERE d.campaign_id=:id AND c.`user_id`=:user_id')->bindValues(['id' => $id, 'user_id' => Yii::$app->user->id])->queryOne();

        $model = Yii::$app->db->createCommand('SELECT * FROM campaign WHERE id=:id')->bindValue(':id', $id)->queryOne();

        if (empty($model['judul_campaign'])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('pencairan', [
                'model' => $model,
        ]);
    }

    public function actionDownloadFormPernyataan($id)
    {
        $this->layout = '/print';
        $model = Yii::$app->db->createCommand('SELECT c.judul_campaign, c.terkumpul, u.username, up.nama_lengkap, up.bio_singkat FROM campaign as c
LEFT JOIN `user` as u ON u.id = c.user_id
LEFT JOIN `user_profile` as up ON up.user_id = c.user_id WHERE c.id=:id AND c.user_id=:userId')->bindValues([':id' => $id, ':userId' => Yii::$app->user->id])->queryOne();

        if (empty($model['judul_campaign'])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('download-form-pernyataan', [
                'model' => $model,
        ]);
    }

//    public function actionUpdate($id)
//    {
//        $this->layout = '/dashboard/main';
//        $model = $this->findModel($id);
//
//        if (Yii::$app->user->id == $model->user_id) {
//            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//                $model->deadline = date('Y-m-d', strtotime($model->deadline));
//                $model->save();
//                Yii::$app->session->setFlash('success', ' Data has been saved!');
//                return $this->redirect(['index']);
//            } else {
//                $model->deadline = date('d-m-Y', strtotime($model->deadline));
//
//                return $this->render('update', [
//                    'model' => $model,
//                ]);
//            }
//        } else {
//            Yii::$app->session->setFlash('warning', 'Halaman tidak ditemukan');
//            return $this->redirect('/dashboard/campaign/');
//        }
//    }

    public function actionDelete($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->findModel($id)->delete()) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Data has been removed!');
                return $this->redirect(['index']);
            }
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger', 'Failure, Data failed removed');
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelDonaturOffline($id)
    {
        if (($model = DonaturOffline::findOne(['id' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelCampaign($id)
    {
        if (($model = Campaign::findOne(['id' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
