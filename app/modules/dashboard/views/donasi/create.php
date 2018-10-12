<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Donasi */

$this->title = Yii::t('app', 'Tambah Donasi');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Donasis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="donasi-create">

    <h1><?php Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
