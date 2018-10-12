<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Campaign;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User Profile',
]) . ' ' . $model->user_id;
// $this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => '/dashboard/'];
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-profile-update">

    <h1><?php //Html::encode($this->title) ?></h1>

    <div class="user-profile-form form">
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ],
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "<div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-7\">{input}{error}</div><div class=\"col-md-3\"></div>\n",
                'labelOptions' => ['class' => 'text-left1'],
            ],
            //'enableAjaxValidation' => true,
            //'validateOnBlur' => true
    ]); ?>

    <div class="panel">
        <div class="panel-body">
            <?php 
            $model->email = Yii::$app->user->identity->email;
            echo $form->field($model, 'email')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'nama_lengkap')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'bio_singkat')->textArea(['maxlength' => true]) ?>
            <?= $form->field($model, 'no_telp')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'imageFile')->fileInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'lokasi_id')->dropDownlist(Campaign::getDaftarLokasi(), ['prompt' => 'Lokasi Anda']) ?>

            <div class="col-md-2"></div>    
            <div class="form-group">
                <?= Html::submitButton( '<i class="glyphicon glyphicon-floppy-disk glyphicon-sm"> </i>'.Yii::t('app', ' Simpan') , ['class' => 'btn btn-primary btn-sm' ]) ?> &nbsp
                <?= Html::a('<i class="glyphicon glyphicon-remove glyphicon-sm"></i> Cancel ', ['/dashboard/profil/'], ['class' => 'btn btn-danger btn-sm']) ?>
            </div>
        </div>
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
