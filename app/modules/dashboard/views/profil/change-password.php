<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Campaign;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = Yii::t('app', 'Ganti Kata Sandi');
// $this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => '/dashboard/'];
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>
<div class="user-profile-update">
    <h1><?php Html::encode($this->title) ?></h1>
    <div class="user-profile-form form">
        <?php
        $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-horizontal',
                    'enctype' => 'multipart/form-data'
                ],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "<div class=\"col-md-3\">{label}</div>\n<div class=\"col-md-7\">{input}{error}</div><div class=\"col-md-3\"></div>\n",
                    'labelOptions' => ['class' => 'text-left1'],
                ],
                //'enableAjaxValidation' => true,
                //'validateOnBlur' => true
        ]);

        ?>

        <div class="panel">
            <div class="panel-body">
                <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => true]) ?>

                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk glyphicon-sm"> </i>' . Yii::t('app', ' Simpan'), ['class' => 'btn btn-primary btn-sm']) ?> &nbsp
                        <?= Html::a('<i class="glyphicon glyphicon-remove glyphicon-sm"></i> Cancel ', Yii::$app->request->referrer, ['class' => 'btn btn-danger btn-sm']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>