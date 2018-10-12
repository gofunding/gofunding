<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Banner;
    use app\modules\admin\models\search\BannerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\UploadedFile;
use app\models\BannerUpload;

/**
* created haifahrul
*/

class BannerController extends Controller
 {
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

    public function actionIndex()
    {
                    $searchModel = new BannerSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
            }

    public function actionView($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionCreate()
    {
        $model = new Banner();
        $bannerUpload = new BannerUpload();
        $is_ajax= Yii::$app->request->isAjax;
        $postdata= Yii::$app->request->post(); 
        
        if ($model->load($postdata) && $model->validate() && $bannerUpload->load($postdata)) {
            $transaction = Yii::$app->db->beginTransaction();
            try { 
                $bannerUpload->imageFile = UploadedFile::getInstance($bannerUpload, 'imageFile');

                if ($bannerUpload->upload()) {
                    // file is uploaded successfully
                    $model->path = $bannerUpload->filename;
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', ' Data telah disimpan!');
                        
                        return $this->redirect(['index']);
                    }
                }
            } catch(Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        } 

        if ($is_ajax) {
            return $this->renderAjax('create', [
                'model' => $model,
                'bannerUpload' => $bannerUpload
            ]);            
        } else {    
            return $this->render('create', [
                'model' => $model,
                'bannerUpload' => $bannerUpload
            ]);
        }
    }   

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImage = Yii::$app->params['uploadPath'] . '/banner/' . $model->path;
        $bannerUpload = new BannerUpload();
        $postdata= Yii::$app->request->post(); 

        if ($model->load($postdata) && $model->validate() && $bannerUpload->load($postdata)) {
            $transaction = Yii::$app->db->beginTransaction();
            try { 
                $bannerUpload->imageFile = UploadedFile::getInstance($bannerUpload, 'imageFile');

                if ($bannerUpload->upload()) {
                    // file is uploaded successfully

                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }

                    $model->path = $bannerUpload->filename;
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', ' Data telah disimpan!');
                        
                        return $this->redirect(['index']);
                    }
                }
            } catch(Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('update', [
                    'model' => $model,
                    'bannerUpload' => $bannerUpload
                ]);            
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'bannerUpload' => $bannerUpload
                ]);
            }
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $oldFile = $model->path;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->delete()) {
                $transaction->commit();
                unlink(Yii::$app->params['uploadPath'] . 'banner/' . $oldFile);
                Yii::$app->session->setFlash('success', 'Data has been removed!');

                return $this->redirect(['index']);
            }
        } catch(Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger', 'Failure, Data failed removed');
        }
        return $this->redirect(['index']);
    }

    // Delete selected items use ajax
    public function actionDeleteItems()
    {
        $status = 0 ;
        if (isset($_POST['keys'])) {
            $keys = $_POST['keys'];
            foreach ($keys as $key ):
                $model = Banner::findOne($key);
                if($model->delete())
                    $status=1;
                else
                    $status=2;
            endforeach;

            //$model = Banner::findOne($keys);
            //$model->delete();
            //$status=3;
        }
        // retrun is json
        echo Json::encode([
            'status' => $status  ,
        ]);          
    }

    protected function findModel($id)
    {
                if (($model = Banner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}