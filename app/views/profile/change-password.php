<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\themes\adminlte\components\Skins;

$this->title = Yii::t('app', 'Ganti Password');
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = 'List' . $this->title;
?>

<div class="nav-tabs-custom">
    <?= \app\widgets\adminlte\Menu::widget(\app\components\Menus::getMenuProfileTab()) ?>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                <?php $form = ActiveForm::begin(['id' => 'change-password']); ?>
                <?= $form->field($model, 'old_password')->passwordInput() ?>
                <?= $form->field($model, 'new_password')->passwordInput() ?>
                <?= $form->field($model, 'repeat_password')->passwordInput() ?>        
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'data' => [
			'confirm' => 'Anda yakin akan memperbaharui password?',
			'method' => 'post'
		    ]]) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>