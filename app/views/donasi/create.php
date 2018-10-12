<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Donasi */

$this->title = Yii::t('app', 'Create Donasi');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Donasis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donasi-create">

	<div class="text-center">
	    <h4>Kamu akan berdonasi untuk campaign</h3>
		<h4><strong>asdas</strong></h3>
	</div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nominal_donasi')->textInput() ?>

    <?= $form->field($model, 'is_anonim')->checkbox() ?>
    <?= $form->field($model, 'komentar')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone_penerima_sms')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'bank_id')->textInput() ?>

    <?= $form->field($model, 'transfer_sebelum')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
