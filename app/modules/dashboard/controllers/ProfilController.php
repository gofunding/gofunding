<?php
namespace app\modules\dashboard\controllers;

use app\models\User;
use app\models\UserProfile;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * created haifahrul
 */
class ProfilController extends Controller
{

    public function beforeAction($action)
    {
        if (($action->id == 'change-password' || $action->id == 'update') && $id = $_GET['id']) {
            $model = $this->findModel($id);

            if (Yii::$app->user->id == $model->user_id) {
                return parent::beforeAction($action);
            }

            return $this->redirect('/error');
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->layout = '/dashboard/main';
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);

        return $this->render('view', [
                'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $this->layout = '/dashboard/main';
        $model = $this->findModel($id);
        if (Yii::$app->user->id == $model->user_id) {
            $model->scenario = 'update-profile';
            $oldAvatar = $model->avatar;

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                try {
                    $uploadFile = UploadedFile::getInstances($model, 'imageFile');
                    if (!empty($uploadFile)) {
                        $model->avatar = sha1(Yii::$app->user->id . microtime()) . '.' . $uploadFile[0]->extension;
                        $uploadFile[0]->saveAs(Yii::$app->params['uploadPath'] . '/avatar/' . $model->avatar);
                    }

                    if ($model->save()) {
                        if (!empty($oldAvatar) && !empty($uploadFile)) {
                            unlink(Yii::$app->params['uploadPath'] . '/avatar/' . $oldAvatar);
                        }
                    }

                    Yii::$app->session->setFlash('success', ' Data berhasil disimpan');
                    return $this->redirect(['index']);
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('danger', ' Data gagal disimpan');
                    return $this->redirect(['index']);
                }
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
        } else {
            Yii::$app->session->setFlash('warning', 'Halaman tidak ditemukan');
            return $this->redirect('/dashboard/profil/');
        }
    }

    public function actionChangePassword($id)
    {
        $this->layout = '/dashboard/main';
        $model = $this->findModelUser($id);
        $model->scenario = 'change-password';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->new_password);
            
            if ($model->save()) {
                Yii::$app->session->setFlash('danger', 'Data berhasil diubah');
                return $this->redirect('/dashboard/profil/');
            } else {
                Yii::$app->session->setFlash('danger', 'Data gagal diubah');
            }
        }

        return $this->render('change-password', ['model' => $model]);
    }

    protected function findModelUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel($id)
    {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
