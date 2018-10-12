<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\themes\adminlte\components\Skins;

$this->title = Yii::t('app', 'Profil');
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = 'List' . $this->title;
?>

<div class="nav-tabs-custom">
    <?= \app\widgets\adminlte\Menu::widget(\app\components\Menus::getMenuProfileTab()) ?>
    <div class="box-body">
        <?php $form = ActiveForm::begin(['id' => 'profile']); ?>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="text-center">
                    <img style="width: 25%" src="<?= $modelUserProfile->getAvatar() ?>">
                </div>
                <br>
                <div class="col-md-offset-2">
                    <!-- <div class="row">
                        <div class="col-xs-4"><b>NIP</b></div>
                        <div class=""></div>
                    </div> -->
                    <br>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <?= $form->field($modelUser, 'username')->textInput() ?>
                <?= $form->field($modelUser, 'email')->textInput() ?>
                <?= $form->field($modelUserProfile, 'firstname')->textInput() ?>
                <?= $form->field($modelUserProfile, 'lastname')->textInput() ?>
                <?= $form->field($modelUserProfile, 'no_telp')->textInput() ?>
                <?= $form->field($modelUserProfile, 'imageFile')->fileInput() ?>
                <div class="form-group">
                    <?=
                    Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'data' => [
                            'confirm' => 'Anda yakin akan memperbaharui profil?',
                            'method' => 'post',
                        ],])
                    ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>