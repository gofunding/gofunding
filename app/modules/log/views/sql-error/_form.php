<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\log\models\LogSqlError */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-sql-error-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sql_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'object_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'error_number')->textInput() ?>

    <?= $form->field($model, 'row_count')->textInput() ?>

    <?= $form->field($model, 'sql_state')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'error_message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
