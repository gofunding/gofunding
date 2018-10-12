<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\log\models\LoginSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="login-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'log_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'os_device') ?>


    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
