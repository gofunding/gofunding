<?php
namespace app\modules\admin\controllers;

use Yii;
use app\models\Campaign;
use app\models\UserProfile;
use app\modules\admin\models\search\CampaignSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * created haifahrul
 */
class ConfirmationPaymentController extends Controller
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
    }

    // public function actionCreate()
    // {
    //     $model = new Campaign();
    //     $is_ajax= Yii::$app->request->isAjax;
    //     $postdata= Yii::$app->request->post(); 
    //     if ($model->load($postdata)&& $model->validate()) {
    //         $transaction = Yii::$app->db->beginTransaction();
    //         try { 
    //             if ($model->save()) {
    //                 $transaction->commit();
    //                 Yii::$app->session->setFlash('success', ' Data telah disimpan!');
    //                 return $this->redirect(['index']);
    //             }
    //         } catch(Exception $e) {
    //             $transaction->rollback();
    //             throw $e;
    //         }
    //     } 
    //     if ($is_ajax) {
    //         return $this->renderAjax('create', [
    //             'model' => $model,
    //         ]);            
    //     } else {    
    //         return $this->render('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }   
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         Yii::$app->session->setFlash('success', ' Data has been saved!');
    //         return $this->redirect(['index']);
    //     } else {
    //         if (Yii::$app->request->isAjax) {
    //             return $this->renderAjax('update', [
    //                 'model' => $model,
    //             ]);            
    //         } else {
    //             return $this->render('update', [
    //                 'model' => $model,
    //             ]);
    //         }
    //     }
    // }
    // public function actionDelete($id)
    // {
    //     $transaction = Yii::$app->db->beginTransaction();
    //     try {
    //         if ($this->findModel($id)->delete()) {
    //             $transaction->commit();
    //             Yii::$app->session->setFlash('success', 'Data has been removed!');
    //             return $this->redirect(['index']);
    //         }
    //     } catch(Exception $e) {
    //         $transaction->rollback();
    //         Yii::$app->session->setFlash('danger', 'Failure, Data failed removed');
    //     }
    //     return $this->redirect(['index']);
    // }

    public function actionApprove($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($id);
            $model->scenario = 'updateIsActive';
            $model->is_active = 2;
            if ($model->save()) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Campaign berhasil diterima');
                return $this->redirect(['index']);
            }
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger', 'Data gagal disimpan');
        }
        return $this->redirect(['index']);
    }

    public function actionDenied($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($id);
            $model->scenario = 'updateIsActive';
            $model->is_active = 4;
            if ($model->save()) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Campaign berhasil di tolak');
                return $this->redirect(['index']);
            }
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger', 'Data gagal disimpan');
        }
        return $this->redirect(['index']);
    }

    public function actionProfilCampaigner($id)
    {
        $model = $this->findModelUserCampaigner($id);

        if ($model) {
            return $this->render('profil-campaigner', ['model' => $model]);
        }
    }

    // Delete selected items use ajax
    // public function actionDeleteItems()
    // {
    //     $status = 0 ;
    //     if (isset($_POST['keys'])) {
    //         $keys = $_POST['keys'];
    //         foreach ($keys as $key ):
    //             $model = Campaign::findOne($key);
    //             if($model->delete())
    //                 $status=1;
    //             else
    //                 $status=2;
    //         endforeach;
    //         //$model = Campaign::findOne($keys);
    //         //$model->delete();
    //         //$status=3;
    //     }
    //     // retrun is json
    //     echo Json::encode([
    //         'status' => $status  ,
    //     ]);          
    // }

    protected function findModel($id)
    {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelUserCampaigner($id)
    {
        if (($model = UserProfile::find()->where(['user_id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
