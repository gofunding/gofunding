<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Banner',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banner'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="banner-update panel panel-default">

    <div class="panel-heading">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="text-center">
            <img style="width: 25%" src="<?= Yii::$app->helpers->displayImage('banner', $model->path) ?>">
        </div>
    </div>

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'bannerUpload' => $bannerUpload
        ]) ?>
    </div>

</div>
