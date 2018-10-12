<?php 
use yii\helpers\Html;
?>	

<section>
<div id="campaign-create-step-3">
	<div class="row">
		<div class="col-xl-12 col-md-12">
			<div class="panel">
				<div class="panel-body">
					<h4>Selangkah lagi sebelum campaign kamu siap digunakan!</h4>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xl-12 col-md-12">
			<div class="panel">
				<div class="panel-body text-center">
					<p class="fa fa-phone fa-3x"></p>
					<h4>Nomor Handphone</h4>
					<p>Pastikan nomor handphone kamu di bawah ini benar</p>

					<div class="col-md-6 col-md-offset-2">
						<?= $form->field($modelProfile, 'no_telp')->textInput(['maxlength' => true])->label(false)?>
					</div>

					<p>
						<div class="label label-success">
							<!-- Nomor ini akan digunakan untuk mengirim kode unik setiap kali kamu ingin mencairkan donasi. -->
							Nomor ini akan digunakan untuk mengirim informasi status campaign Anda.
						</div>
					</p>

					<!-- LANJUT -> menu ini akan di redirect ke view/id -->

					<p>
						<?php echo Html::button('Previous', ['id' => 'btn-prev-step-2', 'class' => 'btn btn-default']) ?> &nbsp&nbsp
						<?php echo Html::submitButton(Yii::t('app', 'MULAI CAMPAIGN'), ['id' => 'btn-create-campaign', 'class' => 'btn btn-success']) ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
</section>