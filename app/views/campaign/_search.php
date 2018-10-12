<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CampaignKategori;

/* @var $this yii\web\View */
/* @var $model app\models\search\CampaignSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-search panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <h3>Halo #OrangBaik, </h3>
                <h4>Pilih campaign yang ingin kamu bantu</h4>
            </div>
            <div class="col-md-6">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

                <?php // $form->field($model, 'id') ?>
                <?php // $form->field($model, 'user_id') ?>
                <?php // $form->field($model, 'judul_campaign') ?>
                <?php // $form->field($model, 'target_donasi') ?>
                <?php // $form->field($model, 'link') ?>
                <?php // echo $form->field($model, 'deadline') ?>
                <?php echo $form->field($model, 'kategori_id')->dropDownlist(CampaignKategori::getDaftarKategori(), ['prompt' => 'Semua Kategori'])->label(false) ?>
                <?php // echo $form->field($model, 'lokasi_id') ?>
                <?php // echo $form->field($model, 'cover_image') ?>
                <?php // echo $form->field($model, 'video_url') ?>
                <?php // echo $form->field($model, 'deskripsi_singkat') ?>
                <?php // echo $form->field($model, 'deskripsi_lengkap') ?>
                <?php // echo $form->field($model, 'is_agree') ?>
                <?php // echo $form->field($model, 'is_active') ?>
                <?php // echo $form->field($model, 'created_at') ?>
                <?php // echo $form->field($model, 'updated_at') ?>
                <?php // echo $form->field($model, 'created_by') ?>
                <?php // echo $form->field($model, 'updated_by') ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                    <?php // Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>