<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm 
	author A. Fakhrurozi S.
*/

?>
<div class="banner-form form">
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'form-horizontal',
        ],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-7\">{input}{error}</div><div class=\"col-md-3\"></div>\n",
            'labelOptions' => ['class' => 'text-left1'],
        ],
            //'enableAjaxValidation' => true,
            //'validateOnBlur' => true
		
    ]); ?>

    <?php echo $form->field($bannerUpload, 'imageFile')->fileInput() ?>
    <?php 
    // echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [
    //     'options' => ['accept' => 'image/*'],
    // ]);
    ?>
    <?= $form->field($model, 'order')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'is_active')->dropDownList(Yii::$app->globalFunction->isActive()) ?>

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