<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Campaign;
use app\models\CampaignKategori;
use kartik\date\DatePicker;

/* @var $model app\models\Campaign */
/* @var $form yii\widgets\ActiveForm
  author A. Fakhrurozi S.
 */

?>
<div class="campaign-form form">
    <?php
    $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal'],
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "<div class=\"col-md-3\">{label}</div>\n<div class=\"col-md-6\">{input}{error}</div><div class=\"col-md-3\"></div>\n",
                'labelOptions' => ['class' => 'text-left1'],
            ],
            //'enableAjaxValidation' => true,
            //'validateOnBlur' => true
    ]);

    ?>

    <?= $form->field($model, 'judul_campaign')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'target_donasi')->textInput(['maxlength' => true, 'placeholder' => 'Berapa target donasi yang kamu butuhkan? (min. Rp.1.000.000)']) ?>
    <?php // $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
    <?=
    $form->field($model, 'deadline')->widget(DatePicker::classname(), [
        'type' => DatePicker::TYPE_INPUT,
        'options' => ['placeholder' => '--- Pilih tanggal ---', 'autocomplete' => 'off'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true
    ]]);

    ?>
    <?= $form->field($model, 'kategori_id')->dropDownlist(CampaignKategori::getDaftarKategori(), ['prompt' => 'Pilih kategori yang paling sesuai']) ?>
    <?= $form->field($model, 'lokasi_id')->dropDownlist(Campaign::getDaftarLokasi(), ['prompt' => 'Pilih lokasi penerima dana campaign']) ?>
    <?= $form->field($model, 'cover_image')->fileInput(); ?>
    <?php // $form->field($model, 'video_url')->textInput(['maxlength' => true, 'prompt' => 'Contoh: http://youtube.com']) ?>
    <?= $form->field($model, 'deskripsi_singkat')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'deskripsi_lengkap')->textarea(['rows' => 6]) ?>
    <?php //$form->field($modelProfile, 'no_telp')->textInput(['maxlength' => true])->label(false)?>
    <div class="col-md-6 col-md-offset-3">
        <div class="form-group">
            <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk glyphicon-sm"> </i>' . Yii::t('app', ' Simpan'), ['class' => 'btn btn-primary btn-sm']) ?> &nbsp
            <?= Html::a('<i class="glyphicon glyphicon-remove glyphicon-sm"></i> Cancel ', Yii::$app->request->referrer, ['class' => 'btn btn-danger btn-sm']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$script = <<<JS
$('body').on('beforeSubmit', 'form#{$model->formName()}', function () {
     var form = $(this);
         if (form.find('.has-error').length) {
              return false;
         }
         // submit form
         $.ajax({
              url: form.attr('action'),
              type: 'post',
              data: form.serialize(),
              success: function (response) {
                form.trigger("reset");
                $.pjax.reload({container:'#grid'});
                
              }
         });
   
     return false;
});
JS;
//$this->registerJs($script);

?>