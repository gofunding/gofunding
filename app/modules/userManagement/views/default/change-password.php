<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\Buttons;

/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\User */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-change-password">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>       
            <div class="ui divider"></div>
            <?= $form->field($model, 'new_password')->passwordInput() ?>
            <?= $form->field($model, 'repeat_password')->passwordInput() ?>        
        </div>     
        <div class="box-footer">            
            <?= Buttons::back() ?>            
            <?= Buttons::submitButton() ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>