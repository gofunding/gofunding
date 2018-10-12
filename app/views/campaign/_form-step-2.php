<?php

use yii\helpers\Html;
// use yii\bootstrap\ActiveForm;
use app\models\CampaignKategori;
use app\models\Campaign;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>

<section>
<div class="row">
    <div class="col-md-12">
        <div id="campaign-create-step-2" class="panel">
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
            ]); */?>

            <span class="text-center"><h3>CREATE CAMPAIGN</h3></span>
            <?php
            echo $form->field($model, 'cover_image')->fileInput();
            echo $form->field($model, 'upload_file')->fileInput();
            // echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [
            //     'options' => ['accept' => 'image/*'],
            //     // 'resizeImages' => true,
            //     'pluginOptions' => [
            //         // 'initialPreview'=>[
            //             // "http://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/FullMoon2010.jpg/631px-FullMoon2010.jpg",
            //             // "http://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Earth_Eastern_Hemisphere.jpg/600px-Earth_Eastern_Hemisphere.jpg"
            //         // ],
            //         // 'initialPreviewAsData'=>true,
            //         // 'initialCaption'=>"The Moon and the Earth",
            //         // 'initialPreviewConfig' => [
            //             // ['caption' => 'Moon.jpg', 'size' => '873727'],
            //             // ['caption' => 'Earth.jpg', 'size' => '1287883'],
            //         // ],
            //         'overwriteInitial'=> true,
            //         'validateInitialCount'=> true,
            //         'maxFileSize'=> 1024,
            //         'showPreview' => true,
            //         'showCaption' => true,
            //         'showRemove' => true,
            //         'showUpload' => false,
            //         'allowedFileExtensions' => ['jpg','png','jpeg'],
            //     ]
            // ]);
            ?>
            <?php // $form->field($model, 'video_url')->textInput(['maxlength' => true, 'prompt' => 'Contoh: http://youtube.com']) ?>
            <?= $form->field($model, 'deskripsi_singkat')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'deskripsi_lengkap')->textarea(['rows' => 6]) ?>
            <?php 
            // echo $form->field($model, 'is_agree')->checkbox(['1' => 'Setuju'])
            /*$form->field($model, 'is_agree')->radioList([
                    '1' => 'Setuju',
                    '2' => 'Tidak Setuju'
                ])*/ ?>

            <div class="text-center">
                <?php // Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save & Next') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <hr>
                <p>
                    <?php echo Html::button('Previous', ['id' => 'btn-prev-step-1', 'class' => 'btn btn-default']) ?> &nbsp&nbsp
                <?php echo Html::button(Yii::t('app', 'Save & Next'), ['id' => 'btn-next-step-2', 'class' => 'btn btn-success']) ?>
                </p>
            </div>

            <?php //ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
</section>