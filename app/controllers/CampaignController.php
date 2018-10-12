<?php

namespace app\controllers;

use Yii;
use app\models\UserProfile;
use app\models\Campaign;
use app\models\search\CampaignSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use app\models\Donasi;
use app\models\DonasiUploadStruk;
use app\models\Donatur;
use yii\helpers\ArrayHelper;

/**
 * CampaignController implements the CRUD actions for Campaign model.
 */
class CampaignController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'rules' => [
            //         [
            //             'actions' => ['login', 'error'],
            //             'allow' => true,
            //         ],
            //         [
            //             'actions' => ['logout', 'index'],
            //             'allow' => true,
            //             'roles' => ['@'],
            //         ],
            //     ],
            // ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionIndex() {
        // var_dump(date('Y-m-d H:i:s'));
        // exit;
        $searchModel = new CampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'model' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
        // $query = 'SELECT c.id, c.cover_image, c.judul_campaign, c.target_donasi, DATEDIFF(c.deadline, CURRENT_DATE()) deadline, up.is_community, up.nama_lengkap FROM campaign c LEFT JOIN `user_profile` up ON up.user_id = c.user_id WHERE c.is_active=1 ';
        // if (isset($_GET['CampaignSearch']['kategori_id']) && !empty($_GET['CampaignSearch']['kategori_id'])) {
        //     $kategori_id = $_GET['CampaignSearch']['kategori_id'];
        //     $query .= '&& c.kategori_id=:kategori_id';
        //     $model = Yii::$app->db->createCommand($query)->bindValue(':kategori_id', $kategori_id)->queryAll();
        // } else {
        //     $model = Yii::$app->db->createCommand($query)->queryAll();
        // }
        // return $this->render('index', [
        //     'model' => $model,
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
    }

    /**
     * Displays a single Campaign model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        if (($model->deadline > date('Y-m-d') && $model->is_active == 2) || (Yii::$app->user->id == $model->user_id)) {
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

    /**
     * Creates a new Campaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $userId = Yii::$app->user->id;
        $model = new Campaign();
        $model->scenario = 'create';
        $modelProfile = UserProfile::findOne($userId);
        $modelProfile->scenario = 'campaign-create-form-step-3';
        if (($model->load(Yii::$app->request->post())) && ($modelProfile->load(Yii::$app->request->post()))) {
            $transaction = Yii::$app->db->beginTransaction();
            $model->user_id = $userId;
            $model->deadline = date('Y-m-d', strtotime($model->deadline));
            $model->is_active = 5; // Review
            $model->is_agree = 1;
            $cover_image = UploadedFile::getInstance($model, 'cover_image');
            $upload_proposal = UploadedFile::getInstance($model, 'upload_file');

            if (!empty($cover_image)) {
                $model->cover_image = sha1(Yii::$app->user->id . $cover_image->baseName . microtime()) . '.' . $cover_image->extension;
                $upload = true;
            } else {
                $upload = false;
            }

            if (!empty($upload_proposal)) {
                $model->upload_file = sha1(Yii::$app->user->id . $upload_proposal->baseName . microtime()) . '.' . $upload_proposal->extension;
                $uploadProposal = true;
            } else {
                $uploadProposal = false;
            }

            if ($model->save() && $modelProfile->save() && $model->validate() && $modelProfile->validate()) {
                $transaction->commit();
                if ($upload) {
                    $cover_image->saveAs(Yii::$app->params['uploadPath'] . 'campaign/' . $model->cover_image);
                }
                if ($uploadProposal) {
                    $upload_proposal->saveAs(Yii::$app->params['uploadPath'] . 'campaign/proposal/' . $model->upload_file);
                }
                Yii::$app->session->setFlash('success', ' Data telah disimpan!');

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $transaction->rollBack();
                Yii::$app->session->setFlash('danger', ' Data gagal disimpan! Silahkan cek form Anda.');
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'modelProfile' => $modelProfile,
        ]);
    }

    /**
     * Updates an existing Campaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Campaign model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionContribute($id) {
        $model = new Donasi();
        $judulCampaign = Yii::$app->db->createCommand('SELECT judul_campaign FROM campaign WHERE id=:id')->bindValue(':id', $id)->queryScalar();
        $metodePembayaran = Yii::$app->db->createCommand('SELECT id, nama_bank FROM `bank` WHERE is_active = 1 OR is_va = 1')->queryAll();
        $metodePembayaran = ArrayHelper::map($metodePembayaran, 'id', 'nama_bank');

        try {
            if ($model->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                // set value to table donasi
                $namaPayment = Yii::$app->db->createCommand('SELECT nama_payment FROM `bank` WHERE id=:id')->bindValue(':id', $model->bank_id)->queryScalar();
                $model->campaign_id = $id;
                $model->user_id = Yii::$app->user->id;
                //$model->kode_unik = null;
                $model->tanggal_donasi = date('Y-m-d H:i:s');
                $model->status = $model::STATUS_BELUM_DIBAYAR; // Belum dibayar
//                $model->status = $namaPayment == 'manual_bank_transfer' ? $model::STATUS_MENUNGGU_VERIFIKASI : $model::STATUS_BELUM_DIBAYAR; // Belum dibayar
                $model->is_anonim = $model->is_anonim == 0 ? 2 : 1; // 1 adalah donasi sebagai anonim, 2 bukan anonim
                $model->transfer_sebelum = date('Y-m-d H:i:s', time() + 86400);
                $model->nominal_donasi = (int) $model->nominal_donasi + (int) $model->bank->biaya_per_transaksi;

                if ($model->validate() && $model->save()) {
                    $orderId = $model->id;
                    $statusCode = "200";
                    $grossAmount = $model->nominal_donasi;
                    $serverKey = Yii::$app->params['serverKey'];
                    $input = $orderId . $statusCode . $grossAmount . $serverKey;
                    $model->signature_key = openssl_digest($input, 'sha512');

                    if ($model->update()) {
                        $transaction->commit();

                        // redirect ke halaman detail donasi
                        return $this->redirect(['contributesummary', 'id' => $model->id, 'campaignId' => $id]);
                    }
                }
            }
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger', ' Data gagal disimpan!');

            throw $e;
        }

        return $this->render('contribute', [
                    'model' => $model,
                    'judulCampaign' => $judulCampaign,
                    'metodePembayaran' => $metodePembayaran
        ]);
    }

    public function actionContributesummary($id, $campaignId) {
        $model = $this->findModelDonasi($id);

        if ($model->transfer_sebelum > date('Y-m-d H:i:s')) {
            if ($model->status == $model::STATUS_BELUM_DIBAYAR || $model->status == $model::STATUS_MENUNGGU_VERIFIKASI) {
                $judulCampaign = Yii::$app->db->createCommand('SELECT judul_campaign FROM campaign WHERE id=:id')->bindValue(':id', $campaignId)->queryScalar();
                $phonePenerimaSms = Yii::$app->db->createCommand('SELECT phone_penerima_sms FROM donasi WHERE user_id=:user_id')->bindValue(':user_id', Yii::$app->user->id)->queryScalar();
                $metodePembayaran = Yii::$app->db->createCommand('SELECT * FROM `bank` WHERE id=:id')->bindValue(':id', $model->bank_id)->queryOne();
                $model->nominal_donasi -= $metodePembayaran['biaya_per_transaksi'];
                $total = $metodePembayaran['biaya_per_transaksi'] + $model->nominal_donasi;
                $vaNumber = !empty($metodePembayaran['va_number']) ? array_values((array) json_decode($metodePembayaran['va_number'])) : null;

                if ($metodePembayaran['nama_payment'] == 'manual_bank_transfer') {
                    return $this->render('contribute-summary-manual', [
                                'model' => $model,
                                'judulCampaign' => $judulCampaign,
                                'phonePenerimaSms' => $phonePenerimaSms,
                                'total' => $total,
                                'orderId' => $model->id,
                                'enablePayments' => $metodePembayaran['nama_payment'],
                                'biayaPerTransaksi' => $metodePembayaran['biaya_per_transaksi'],
                                'vaNumber' => $vaNumber[0]->va_number,
                                'receiver' => $vaNumber[0]->receiver,
                    ]);
                } else {
                    return $this->render('contribute-summary', [
                                'model' => $model,
                                'judulCampaign' => $judulCampaign,
                                'phonePenerimaSms' => $phonePenerimaSms,
                                'total' => $total,
                                'orderId' => $model->id,
                                'enablePayments' => $metodePembayaran['nama_payment'],
                                'biayaPerTransaksi' => $metodePembayaran['biaya_per_transaksi'],
                                'vaNumber' => $vaNumber[0]->va_number
                    ]);
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Data anda tidak ditemukan.');

                return $this->redirect('/campaign/index');
            }
        } else {
            Yii::$app->session->setFlash('danger', 'Batas waktu pembayaran sudah lewat, silahkan buat donasi baru.');
            return $this->redirect('/campaign/index');
        }
    }

    /**
     * Confirmation Payment Manual
     */
    public function actionConfirmationPayment($id, $campaignId) {
        if (!empty($id) && !empty($campaignId)) {
            $model = $this->findModelDonasi($id);
            $uploadForm = new DonasiUploadStruk();

            if ($model->transfer_sebelum > date('Y-m-d H:i:s')) {
                if ($model->status == $model::STATUS_BELUM_DIBAYAR || $model->status == $model::STATUS_MENUNGGU_VERIFIKASI) {

                    if ($uploadForm->load(Yii::$app->request->post())) {
                        $transaction = Yii::$app->db->beginTransaction();
                        $model->status = $model::STATUS_MENUNGGU_VERIFIKASI;

                        $uploadForm->file = UploadedFile::getInstance($uploadForm, 'file');

                        if ($uploadForm->upload()) {
                            $model->upload_bukti_transaksi = $uploadForm->upload_bukti_transaksi;
                            if ($model->save()) {
                                // file is uploaded successfully
                                Yii::$app->session->setFlash('success', 'Upload Bukti Transfer Berhasil. <br>Mohon menunggu, kami akan melakukan verifikasai pembayaran Anda. Terima kasih');
                                $transaction->commit();

                                return $this->redirect('/dashboard/donasi/index');
                            }
                        }

                        Yii::$app->session->setFlash('danger', 'Gagal upload bukti transaksi. Silahkan hubungi admin');
                        $transaction->rollBack();
                    }

                    $judulCampaign = Yii::$app->db->createCommand('SELECT judul_campaign FROM campaign WHERE id=:id')->bindValue(':id', $campaignId)->queryScalar();
                    $phonePenerimaSms = Yii::$app->db->createCommand('SELECT phone_penerima_sms FROM donasi WHERE user_id=:user_id')->bindValue(':user_id', Yii::$app->user->id)->queryScalar();
                    $metodePembayaran = Yii::$app->db->createCommand('SELECT * FROM `bank` WHERE id=:id')->bindValue(':id', $model->bank_id)->queryOne();
                    $model->nominal_donasi -= $metodePembayaran['biaya_per_transaksi'];
                    $total = $metodePembayaran['biaya_per_transaksi'] + $model->nominal_donasi;
                    $vaNumber = !empty($metodePembayaran['va_number']) ? array_values((array) json_decode($metodePembayaran['va_number'])) : null;

                    if ($metodePembayaran['nama_payment'] == 'manual_bank_transfer') {
                        return $this->render('confirmation-payment', [
                                    'model' => $model,
                                    'uploadForm' => $uploadForm,
                                    'judulCampaign' => $judulCampaign,
                                    'phonePenerimaSms' => $phonePenerimaSms,
                                    'total' => $total,
                                    'orderId' => $model->id,
                                    'enablePayments' => $metodePembayaran['nama_payment'],
                                    'biayaPerTransaksi' => $metodePembayaran['biaya_per_transaksi'],
                                    'vaNumber' => $vaNumber[0]->va_number,
                                    'receiver' => $vaNumber[0]->receiver,
                        ]);
                    } else {
                        Yii::$app->session->setFlash('danger', 'Data anda tidak ditemukan.');

                        return $this->redirect('/campaign/index');
                    }
                } else {
                    Yii::$app->session->setFlash('danger', 'Data anda tidak ditemukan.');

                    return $this->redirect('/campaign/index');
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Batas waktu pembayaran sudah lewat, silahkan buat donasi baru.');
                return $this->redirect('/campaign/index');
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Campaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Campaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelDonasi($id) {
        if (($model = Donasi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
