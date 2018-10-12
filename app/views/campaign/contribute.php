<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <h4>Kamu akan berdonasi untuk campaign</h4>
                <h4><b><?= $judulCampaign ?></b></h4>
            </div>
        </div>
    </div> <br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel">
                <div class="panel-body text-center">
                    <?php $form = ActiveForm::begin([]); ?>
                    <h3><b>Masukkan Nominal</b></h3>
                    <p>Donasi minimal Rp.20.000 dengan kelipatan ribuan (contoh: 25.000, 50.000)</p>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <?= $form->field($model, 'nominal_donasi')->textInput(['type' => 'number', 'maxlength' => true])->label(false) ?>        
                            <?= $form->field($model, 'is_anonim')->checkbox() ?>
                        </div>
                    </div>

                    <h3><b>Tulis Komentar</b></h2>
                    <h5><b>Teks saja, tanpa URL/kode html, dan emoticon.</b></h5>
                    <?= $form->field($model, 'komentar')->textarea(['maxlength' => true, 'placeholder' => 'Tulis komentar yang mendukung campaign (opsional)'])->label(false) ?>

                    <h3><b>Nomor HP Anda</b></h2>
                    <h5>Masukan nomor HP Anda untuk menerima SMS status donasi</h5>
                    <?= $form->field($model, 'phone_penerima_sms')->textInput(['type' => 'number', 'placeholder' => 'Format 08xxx atau 62xxx (angka saja)'])->label(false) ?>
                    
                    <h3><b>Pilih Metode Pembayaran</b></h2>
                    <?= $form->field($model, 'bank_id')->dropDownList($metodePembayaran, ['prompt' => ''])->label(false) ?>
                    
                    <div class="pull-right">
                        <?= Html::submitButton(Yii::t('app', 'Save & Next'), ['class' => 'btn btn-success']) ?>
                    </div>
                
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<br>