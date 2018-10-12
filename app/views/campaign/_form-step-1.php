<?php

use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;
use app\models\CampaignKategori;
use app\models\Campaign;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>

<section>
<div class="row">
    <div class="col-md-12">
        <div id="campaign-create-step-1" class="panel">
            <div class=" panel-body">
            <?php /*$form = ActiveForm::begin([
                'options' => ['class' => 'form-horizontal'],
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "<div class=\"col-md-4\">{label}</div>\n<div class=\"col-md-8\">{input}{error}</div><div class=\"col-md-3\"></div>\n",
                    'labelOptions' => ['class' => 'text-left1'],
                ],
                    //'enableAjaxValidation' => true,
                    //'validateOnBlur' => true
            ]);*/ ?>
            <span class="text-center"><h3>INFORMASI CAMPAIGN</h3></span>

            <?= $form->field($model, 'judul_campaign')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'target_donasi')->textInput(['maxlength' => true, 'placeholder' => 'Berapa target donasi yang kamu butuhkan? (min. Rp.1.000.000)']) ?>
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

            <div class="text-center">
                <hr>
                <p>
                    <?php echo Html::button(Yii::t('app', 'Save & Next'), ['id' => 'btn-next-step-1', 'class' => 'btn btn-success']) ?>
                </p>
            </div>

            <?php //ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
</section>