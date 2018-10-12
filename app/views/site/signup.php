<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Daftar';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="hidden-sm hidden-xs">
    <br><br>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="site-login panel panel-default text-center">
            <div class="panel-body">
                <h2>Hi, Orang Baik!</h2>
                <h4>Selamat bergabung di komunitas orang baik terbesar di Indonesia.</h4>
                <hr>
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    // 'layout' => 'horizontal',
                    // 'fieldConfig' => [
                    //     'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    //     'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    // ],
                ]); ?>
                <?= $form->field($model, 'nama_lengkap')->textInput(['placeholder' => 'Nama Anda / Komunitas', 'autofocus' => true])->label(false) ?>
                <?= $form->field($model, 'username')->textInput(['placeholder' => 'NPM / NIK', 'autofocus' => true])->label(false) ?>
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email', 'autofocus' => true])->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
                <?= $form->field($model, 'repeatPassword')->passwordInput(['placeholder' => 'Ulangi Password'])->label(false) ?>
                <?= $form->field($model, 'is_community')->checkbox()->label('Gabung sebagai organisasi/komunitas') ?>

                <div class="form-group">
                    <div class="">
                        <?= Html::submitButton('Daftar', ['class' => 'btn btn-success btn-md btn-block', 'name' => 'login-button']) ?>
                    </div>
                </div>
                <hr>
                <p> Sudah punya akun? Silahkan <a href="<?= Url::to('login') ?>">Login</a></p>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>