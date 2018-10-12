<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $model app\models\DonaturOffline */
/* @var $form yii\widgets\ActiveForm 
  author A. Fakhrurozi S.
 */

?>
<div class="donatur-offline-form form panel-body">
    <?php
    $form = ActiveForm::begin([
            'options' => [
                'class' => 'form-horizontal'],
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "<div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-10\">{input}{error}</div><div class=\"col-md-3\"></div>\n",
                'labelOptions' => ['class' => 'text-left1'],
            ],
            //'enableAjaxValidation' => true,
            //'validateOnBlur' => true
    ]);

    ?>

    <?= $form->field($model, 'nama_donatur')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nominal_donasi')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tanggal_donasi')->textInput(['maxlength' => true, 'type' => 'date']) ?>

    <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk glyphicon-sm"> </i>' . Yii::t('app', ' Simpan'), ['class' => 'btn btn-success btn-sm']) ?> &nbsp
    <?= Html::a('<i class="glyphicon glyphicon-remove glyphicon-sm"></i> Cancel ', Yii::$app->request->referrer, ['class' => 'btn btn-danger btn-sm']) ?>

    <?php ActiveForm::end(); ?>

</div>
