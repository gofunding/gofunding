<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\search\CampaignSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'judul_campaign') ?>

    <?= $form->field($model, 'target_donasi') ?>

    <?= $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'deadline') ?>

    <?php // echo $form->field($model, 'kategori_id') ?>

    <?php // echo $form->field($model, 'lokasi_id') ?>

    <?php // echo $form->field($model, 'cover_image') ?>

    <?php // echo $form->field($model, 'video_url') ?>

    <?php // echo $form->field($model, 'deskripsi_singkat') ?>

    <?php // echo $form->field($model, 'deskripsi_lengkap') ?>

    <?php // echo $form->field($model, 'terkumpul') ?>

    <?php // echo $form->field($model, 'is_reached') ?>

    <?php // echo $form->field($model, 'is_agree') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'is_community') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
