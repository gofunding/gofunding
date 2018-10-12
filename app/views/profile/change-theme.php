<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\themes\adminlte\components\Skins;

$this->title = Yii::t('app', 'Ganti Tema');
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = 'List' . $this->title;
?>

<div class="nav-tabs-custom">
    <?= \app\widgets\adminlte\Menu::widget(\app\components\Menus::getMenuProfileTab()) ?>
    <div class="row">
        <div class="box-body">
            <div class="col-xs-12">
                <?php $form = ActiveForm::begin(['id' => 'change-theme']); ?>
                <?= $form->field($model, 'theme')->dropDownList(Skins::getListSkin($model->theme), ['prompt' => '--- Pilih ---'])->label('Daftar Tema') ?>
                <div class="form-group"><?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?> </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>