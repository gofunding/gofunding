<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\log\models\LogSqlError */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Log Sql Error',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Log Sql Errors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="log-sql-error-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
