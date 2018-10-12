<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\log\models\search\SqlError */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-sql-error-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sql_text') ?>

    <?= $form->field($model, 'object_name') ?>

    <?= $form->field($model, 'error_number') ?>

    <?= $form->field($model, 'row_count') ?>

    <?php // echo $form->field($model, 'sql_state') ?>

    <?php // echo $form->field($model, 'error_message') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
