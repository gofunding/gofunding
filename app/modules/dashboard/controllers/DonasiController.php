<?php
namespace app\modules\dashboard\controllers;

use app\models\Donasi;
use app\modules\dashboard\models\search\DonasiSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * created haifahrul
 */
class DonasiController extends Controller
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
        $this->layout = '/dashboard/main';
        $searchModel = new DonasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $this->layout = '/dashboard/main';
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

    protected function findModel($id)
    {
        if (($model = Donasi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
