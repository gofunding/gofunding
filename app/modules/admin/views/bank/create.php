<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = Yii::t('app', 'Tambah Bank');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bank'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
    <div class="bank-create panel panel-default">

        <div class="panel-heading">
        <h3>
            <?= Html::encode($this->title) ?>
        </h3>
        </div>

        <div class="panel-body">
            <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
        </div>

    </div>