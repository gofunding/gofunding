<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\log\models\Login */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Login',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Login'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="login-update">

    <h1><?php //Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
