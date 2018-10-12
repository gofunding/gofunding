<?php

/**
* This is the template for generating a CRUD controller class file.
*/
use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);

if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
    use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
    use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
* created haifahrul
*/

class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?> {
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
        <?php if (!empty($generator->searchModelClass)): ?>
            $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
        <?php else: ?>
            $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
            ]);

            return $this->render('index', [
            'dataProvider' => $dataProvider,
            ]);
        <?php endif; ?>
    }

    public function actionView(<?= $actionParams ?>)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $this->findModel(<?= $actionParams ?>),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel(<?= $actionParams ?>),
            ]);
        }
    }

    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();
        $is_ajax= Yii::$app->request->isAjax;
        $postdata= Yii::$app->request->post(); 

        if ($model->load($postdata)&& $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try { 
                if ($model->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', ' Data telah disimpan!');
                    return $this->redirect(['index']);
                }
            } catch(Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        } 

        if ($is_ajax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);            
        } else {    
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }   

    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

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

    public function actionDelete(<?= $actionParams ?>)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($this->findModel(<?= $actionParams ?>)->delete()) {
                $transaction->commit();
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
                $model = <?= $modelClass ?>::findOne($key);
                if($model->delete())
                    $status=1;
                else
                    $status=2;
            endforeach;

            //$model = <?= $modelClass ?>::findOne($keys);
            //$model->delete();
            //$status=3;
        }
        // retrun is json
        echo Json::encode([
            'status' => $status  ,
        ]);          
    }

    protected function findModel(<?= $actionParams ?>)
    {
        <?php
        if (count($pks) === 1) {
            $condition = '$id';
        } else {
            $condition = [];
            foreach ($pks as $pk) {
                $condition[] = "'$pk' => \$$pk";
            }
            $condition = '[' . implode(', ', $condition) . ']';
        }
        ?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
