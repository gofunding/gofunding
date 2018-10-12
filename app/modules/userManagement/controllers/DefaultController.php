<?php

namespace app\modules\userManagement\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\modules\userManagement\models\User;
use app\modules\userManagement\models\UserSearch;
use app\modules\userManagement\models\UserProfile;
use app\modules\userManagement\models\AuthAssignment;
use app\modules\userManagement\models\AuthItem;

/**
 * Default controller for the `userManagement` module
 * 
 * created by haifahrul <haifahrul@gmai.com>
 */
class DefaultController extends \app\modules\log\controllers\MainController {

    /**
     * UserController implements the CRUD actions for User model.
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'open-banned' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $searchModel->search(Yii::$app->request->queryParams)
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = User::find()
                ->with('userProfile')
                ->where(['user.id' => $id])
                ->one();

        $authAssignments = AuthAssignment::find()->where([
                    'user_id' => $model->id,
                ])->column();

        $authItems = ArrayHelper::map(
                        AuthItem::find()->where([
                            'type' => 1,
                        ])->asArray()->all(), 'name', 'name');

        $authAssignment = new AuthAssignment([
            'user_id' => $model->id,
        ]);

        if (Yii::$app->request->post()) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $authAssignment->load(Yii::$app->request->post());
                if (is_array($authAssignment->item_name)) {
                    // delete all role
                    AuthAssignment::deleteAll(['user_id' => $model->id]);

                    foreach ($authAssignment->item_name as $item) {
                        $authAssignment2 = new AuthAssignment([
                            'user_id' => $model->id,
                        ]);
                        $authAssignment2->item_name = $item;
                        $authAssignment2->created_at = time();
                        $authAssignment2->save();

                        $authAssignments = AuthAssignment::find()->where([
                                    'user_id' => $model->id,
                                ])->column();
                    }

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Data tersimpan');
                }
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        }

        $authAssignment->item_name = $authAssignments;
        return $this->render('view', [
                    'model' => $model,
//                    'model2' => $model2,
                    'authAssignment' => $authAssignment,
                    'authItems' => $authItems,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User();
        $model2 = new UserProfile();
        $model->scenario = 'create';
        $model2->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->setPassword($model->repeat_password);
                $model->status = $model->status == 1 ? 10 : 0;
                if ($model->save()) {
                    $model2->user_id = $model->getPrimaryKey();
                    if ($model2->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'User has been created.');

                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        $transaction->rollback();
                        Yii::$app->session->setFlash('error', 'User gagal dibuat');
                    }
                } else {
                    $transaction->rollback();
                    Yii::$app->session->setFlash('error', 'User gagal dibuat');
                }
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        }
        return $this->render('create', [
                    'model' => $model,
                    'model2' => $model2,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model2 = UserProfile::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post())) {
//            if (!empty($model->new_password)) {
//                $model->setPassword($model->new_password);
//            }
            $model->status = $model->status == 1 ? 10 : 0;
            if ($model->save() && $model2->save()) {
                Yii::$app->session->setFlash('success', 'User berhasil diupdate.');
            } else {
                Yii::$app->session->setFlash('error', 'User gagal diupdate');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->status = $model->status == 10 ? 1 : 0;
            return $this->render('update', [
                        'model' => $model,
                        'model2' => $model2,
            ]);
        }
    }

    public function actionChangePassword($id) {
        $model = $this->findModel($id);
        $model->scenario = 'change-password';

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->setPassword($model->new_password);
                if ($model->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Password has been changed.');

                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('danger', 'Password failed to changed.');
                }
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        }

        return $this->render('change-password', ['model' => $model]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $authAssignments = AuthAssignment::find()->where([
                    'user_id' => $model->id,
                ])->all();
        foreach ($authAssignments as $authAssignment) {
            $authAssignment->delete();
        }

        Yii::$app->session->setFlash('success', 'Delete success');
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionOpenBanned($id) {
        $model = $this->findModel($id);
        $model->status = 10;
        $delete = Yii::$app->db->createCommand('DELETE FROM `login_attempt` WHERE `key` =:username')->bindValue('username', $model->username);

        $transaction = Yii::$app->db->beginTransaction();
        if ($model->save() && $delete->execute()) {
            Yii::$app->session->setFlash('success', 'Akun: ' . $model->username . ' berhasil di aktifkan.');
            $transaction->commit();
        } else {
            Yii::$app->session->setFlash('danger', 'Akun: ' . $model->username . ' gagal di aktifkan.');
            $transaction->rollBack();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
