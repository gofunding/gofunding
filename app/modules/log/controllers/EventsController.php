<?php

namespace app\modules\log\controllers;

use Yii;
use app\modules\log\models\LogEvents;
use app\modules\log\models\search\EventsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * created haifahrul
 */
class EventsController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'], /// Action delete hanya diizinkan post saja 
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/default/index', [
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

    public function actionCreate() {
        $model = new LogEvents();
        $is_ajax = Yii::$app->request->isAjax;
        $postdata = Yii::$app->request->post();
        if ($model->load($postdata) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {

                if ($model->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', ' Data telah disimpan!');
                    return $this->redirect(['index']);
                }
//end if (save) 
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        }

        if ($is_ajax) {
//render view
            return $this->renderAjax('create', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', ' Data has been saved!');
            return $this->redirect(['index']);
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('update', [
                            'model' => $model,
                ]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionDelete($id) {
        $transaction = Yii::$app->db->beginTransaction();
        try {

//query
            if ($this->findModel($id)->delete()):
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Data has been removed!');
                return $this->redirect(['index']);
            else:
                $transaction->rollback();
                Yii::$app->session->setFlash('warning', 'Data failed removed!');
            endif;
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::$app->session->setFlash('danger', 'Failure, Data failed removed');
        }
        return $this->redirect(['index']);
    }

// hapus menggunakan ajax
    public function actionDeleteItems() {
        $status = 0;
        if (isset($_POST['keys'])) {
            $keys = $_POST['keys'];
            foreach ($keys as $key):

                $model = LogEvents::findOne($key);
                if ($model->delete())
                    $status = 1;
                else
                    $status = 2;
            endforeach;

//$model = LogEvents::findOne($keys);
//$model->delete();
//$status=3;
        }
// retrun nya json
        echo Json::encode([
            'status' => $status,
        ]);
    }

    protected function findModel($id) {
        if (($model = LogEvents::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
