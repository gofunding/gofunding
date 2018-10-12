<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\search\DonasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="donasi-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'nominal_donasi') ?>

    <?= $form->field($model, 'tanggal_donasi') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'is_anonim') ?>

    <?php // echo $form->field($model, 'komentar') ?>

    <?php // echo $form->field($model, 'phone_penerima_sms') ?>

    <?php // echo $form->field($model, 'bank_id') ?>

    <?php // echo $form->field($model, 'transfer_sebelum') ?>

    <?php // echo $form->field($model, 'signature_key') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'kode_unik') ?>

    <?php // echo $form->field($model, 'upload_bukti_transaksi') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
