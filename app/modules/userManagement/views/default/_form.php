<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use app\components\Buttons;

/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <div class="col-md-6 col-xs-12">
	    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
	    <?= $form->field($model2, 'firstname')->textInput(['maxlength' => true]) ?>
	    <?= $form->field($model2, 'lastname')->textInput(['maxlength' => true]) ?>
	    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	    <?= $form->field($model2, 'no_telp')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-xs-12">            
	    <?php if ($model->isNewRecord) { ?>
		<?= $form->field($model, 'new_password')->passwordInput() ?>
		<?= $form->field($model, 'repeat_password')->passwordInput() ?>            
	    <?php } ?>                        
	    
	    <?php
	    $model->isNewrecord ? $model->status = 1 : $model->status;
	    echo $form->field($model, 'status')->radioList([
		1 => Yii::t('app', 'Active'),
		0 => Yii::t('app', 'Inactive'),
	    ]);
//            echo $form->field($model, 'status')->widget(SwitchInput::classname(), [
////                'type' => SwitchInput::RADIO,
//                'pluginOptions' => [    
////                    'size' => 'mini',,
//                    'handleWidth'=>60,
//                    'onText' => Yii::t('app', 'Active'),
//                    'offText' => Yii::t('app', 'Inactive'),
//                    'onColor' => Yii::t('app', 'success'),
//                    'offColor' => Yii::t('app', 'danger'),
//                ]
//            ])
	    ?>    
        </div>      
    </div>    
    <div class="box-footer">
        <div class="form-group">
            <p>                                          
		<?= Buttons::submitButton() ?>
		<?= Buttons::cancel() ?>
            </p>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>