<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserProfile;
use app\models\User;
use yii\web\UploadedFile;

class ProfileController extends \app\modules\log\controllers\MainController
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /*
     * @return string
     */

    public function actionIndex() {
        $id = Yii::$app->user->id;
        $modelUser = $this->findModelUser($id);
        $modelUser->scenario = 'update-profile';
        $modelUserProfile = $this->findModel($id);
        $modelUserProfile->scenario = 'update-profile';
        $oldImage = $modelUserProfile->avatar;

        if (($modelUser->load(Yii::$app->request->post()) && $modelUser->validate()) && ($modelUserProfile->load(Yii::$app->request->post()) && $modelUserProfile->validate())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $modelUserProfile->imageFile = UploadedFile::getInstance($modelUserProfile, 'imageFile');

                if (!empty($modelUserProfile->imageFile)) {
                    $ext = pathinfo($modelUserProfile->imageFile->name, PATHINFO_EXTENSION);
                    $modelUserProfile->avatar = sha1($modelUser->email . microtime()) . '.' . $ext;
                }

                if ($modelUser->save() && $modelUserProfile->save()) {
                    if (!empty($model->uploadFile)) {
                        if (!empty($oldFile)) {
                            $path = Yii::$app->params['templateSuratKeluarPath'] . $oldFile;
                            if (file_exists($path)) {
                                unlink($path);
                            }
                        }
                        $model->upload();
                    }
                    if (!empty($modelUserProfile->imageFile)) {
                        if (!empty($oldImage)) {
                            $file = Yii::$app->params['uploadsPath'] . 'avatar/' . $oldImage;
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                        $modelUserProfile->upload();
                    }
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', ' Profil berhasil diubah!');

                    return $this->refresh();
                } else {
                    $transaction->rollback();
                    Yii::$app->session->setFlash('danger', ' Profil gagak diubah, silahkan hubungi Administrator!');

                    return $this->goBack();
                }
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        }

        return $this->render('index', ['modelUser' => $modelUser, 'modelUserProfile' => $modelUserProfile]);
    }

    public function actionChangePassword() {
        $id = Yii::$app->user->id;
        $model = $this->findModelUser($id);
        $model->scenario = 'password';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model->validatePassword($model->old_password)) {
                    $model->setPassword($model->repeat_password);
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', ' Password berhasil diubah!');

                        return $this->refresh();
                    } else {
                        $transaction->rollback();
                        Yii::$app->session->setFlash('danger', ' Password gagal diubah, silahkan hubungi Administrator!');

                        return $this->goBack();
                    }
                } else {
                    $transaction->rollback();
                    Yii::$app->session->setFlash('danger', ' Password gagal diubah, silahkan masukkan password Anda dengan benar sebelum mengganti passowrd baru!');

                    return $this->goBack();
                }
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        }

        return $this->render('change-password', ['model' => $model]);
    }

    public function actionChangeTheme() {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        $model->scenario = 'update-theme';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', ' Berhasil update tema!');

                    return $this->refresh();
                } else {
                    $transaction->rollback();
                    Yii::$app->session->setFlash('danger', ' Gagal mengganti tema, silahkan hubungi Administrator!');

                    return $this->goBack();
                }
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        }

        return $this->render('change-theme', ['model' => $model]);
    }

    protected function findModel($id) {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelUser($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
