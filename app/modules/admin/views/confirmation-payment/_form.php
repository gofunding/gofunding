<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $model app\models\Campaign */
/* @var $form yii\widgets\ActiveForm 
	author A. Fakhrurozi S.
*/

?>
<div class="campaign-form form">
    <?php $form = ActiveForm::begin([
        'options' => [
        'class' => 'form-horizontal'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-7\">{input}{error}</div><div class=\"col-md-3\"></div>\n",
            'labelOptions' => ['class' => 'text-left1'],
        ],
            //'enableAjaxValidation' => true,
            //'validateOnBlur' => true
		
    ]); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'judul_campaign')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'target_donasi')->textInput() ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deadline')->textInput() ?>

    <?= $form->field($model, 'kategori_id')->textInput() ?>

    <?= $form->field($model, 'lokasi_id')->textInput() ?>

    <?= $form->field($model, 'cover_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'video_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deskripsi_singkat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deskripsi_lengkap')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'terkumpul')->textInput() ?>

    <?= $form->field($model, 'is_agree')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="col-md-2"></div>    
    <div class="form-group">
        <?= Html::submitButton( '<i class="glyphicon glyphicon-floppy-disk glyphicon-sm"> </i>'.Yii::t('app', ' Simpan') , ['class' => 'btn btn-primary' ]) ?>
        <?= Html::a('<i class="glyphicon glyphicon-remove glyphicon-sm"></i> Cancel ', Yii::$app->request->referrer, ['class' => 'btn btn-danger  ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $script = <<<JS
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