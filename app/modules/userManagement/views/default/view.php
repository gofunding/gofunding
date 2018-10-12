<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use app\components\Buttons;
use app\components\GlobalFunction;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\User */

$this->title = Yii::t('app', 'View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$formatter = Yii::$app->formatter;
?>
<div class="user-view box">
    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <div class="box-header with-border">
        <p>
            <?= Html::a('<span class="fa fa-arrow-left"></span>', ['default/index'], ['class' => 'btn btn-default btn-sm', 'title' => Yii::t('app', 'Back')]); ?>
            <?= Buttons::update($model->id); ?>
            <?= Html::a('<span class=""><b>' . Yii::t('app', 'Change Password') . '</b></span>', ['change-password', 'id' => $model->id], ['class' => 'btn btn-default btn-sm', 'title' => Yii::t('app', 'Change Password')]); ?>
            <?= Buttons::delete($model->id); ?>            
        </p>
    </div>    
    <div class="box-body">
        <div class="col-sm-5 col-xs-12">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-5 control-label">Username</label>

                    <div class="col-sm-7">
                        <?= $model->username ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label"><?= Yii::t('app', 'Full Name') ?></label>

                    <div class="col-sm-7">
                        <?php $fulllname = $model->userProfile->firstname . ' ' . $model->userProfile->lastname ?>
                        <?= !empty($fulllname) ? $fulllname : '-' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label"><?= Yii::t('app', 'Email') ?></label>

                    <div class="col-sm-7">
                        <?= !empty($model->email) ? $model->email : '-' ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label"><?= Yii::t('app', 'No Telp') ?></label>

                    <div class="col-sm-7">
                        <?= !empty($model->userProfile->no_telp) ? $model->userProfile->no_telp : '-' ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xs-12">    

            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-5 control-label"><?= Yii::t('app', 'Created At') ?></label>

                    <div class="col-sm-7">
                        <?= $formatter->asDatetime($model->created_at) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label"><?= Yii::t('app', 'Updated At') ?></label>

                    <div class="col-sm-7">
                        <?= $formatter->asDatetime($model->updated_at) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label"><?= Yii::t('app', 'Status') ?></label>

                    <div class="col-sm-7">
                        <?= Yii::$app->globalFunction->getStatusUser($model['status']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        DetailView::widget([
            'model' => $model,
            'attributes' => [
//            'id',
                'username',
                [
                    'attribute' => 'Name',
                    'value' => $model->userProfile->firstname . ' ' . $model->userProfile->lastname,
                ],
                [
                    'attribute' => 'no_telp',
                    'value' => $model->userProfile->no_telp,
                ],
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
                'email:email',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => $model['status'] == 10 ? "<span class='label label-success'>" . Yii::t('app', 'Active') . "</span>" : "<span class='label label-danger'>" . Yii::t('app', 'Banned') . "</span>",
                ],
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ])
        ?>
    </div>
    <div class="box-footer">
        <?php $form = ActiveForm::begin([]); ?>
        <?php
        echo $form->field($authAssignment, 'item_name')->widget(Select2::classname(), [
            'data' => $authItems,
            'options' => [
                'placeholder' => 'Select role ...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true,
            ],
        ])->label('Role');
        ?>       
        <?=
        Html::submitButton(Yii::t('app', 'Save'), [
            'class' => $authAssignment->isNewRecord ? 'btn btn-primary btn-sm' : 'btn btn-primary',
                //'data-confirm'=>"Apakah anda yakin akan menyimpan data ini?",
        ])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
