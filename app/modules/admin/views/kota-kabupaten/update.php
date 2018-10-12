<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\KotaKabupaten */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Kota Kabupaten',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Kota Kabupaten'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="kota-kabupaten-update panel panel-default">

    <div class="panel-heading">
    <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>

</div>
