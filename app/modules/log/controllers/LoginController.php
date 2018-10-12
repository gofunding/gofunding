<?php

namespace app\modules\log\controllers;

use Yii;
use app\modules\log\models\Login;
use app\modules\log\models\search\LoginSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * created haifahrul
 */
class LoginController extends Controller {

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
        $searchModel = new LoginSearch();
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

    protected function findModel($id) {
        if (($model = Login::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
