<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\CampaignKategori;
use app\models\Campaign;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-form panel">
    <div class=" panel-body">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div class=\"col-md-4\">{label}</div>\n<div class=\"col-md-8\">{input}{error}</div><div class=\"col-md-3\"></div>\n",
            'labelOptions' => ['class' => 'text-left1'],
        ],
            //'enableAjaxValidation' => true,
            //'validateOnBlur' => true
    ]); ?>

    <?= $form->field($model, 'judul_campaign')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'target_donasi')->textInput() ?>
    <?php // $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'deadline')->widget(DatePicker::classname(), [
        'type' => DatePicker::TYPE_INPUT,
        'options' => ['placeholder' => '--- Pilih tanggal ---', 'autocomplete' => 'off'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
        ]]); ?>
    <?= $form->field($model, 'kategori_id')->dropDownlist(CampaignKategori::getDaftarKategori(), ['prompt' => 'Pilih kategori yang paling sesuai']) ?>
    <?= $form->field($model, 'lokasi_id')->dropDownlist(Campaign::getDaftarLokasi(), ['prompt' => 'Pilih lokasi penerima dana campaign']) ?>

    <div class="pull-right">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save & Next') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>