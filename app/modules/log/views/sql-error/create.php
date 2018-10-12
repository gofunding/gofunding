<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\log\models\LogSqlError */

$this->title = Yii::t('app', 'Create Log Sql Error');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Log Sql Errors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-sql-error-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
