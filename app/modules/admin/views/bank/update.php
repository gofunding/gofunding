<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bank',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bank'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
    <div class="bank-update panel panel-default">

        <div class="panel-heading">
            <h2>
                <?= Html::encode($this->title) ?>
            </h2>
        </div>

        <div class="panel-body">
        <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>

    </div>