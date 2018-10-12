<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CampaignKategori */

$this->title = Yii::t('app', 'Tambah Campaign Kategori');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaign Kategori'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="campaign-kategori-create panel panel-default">

    <div class="panel-heading">
    <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>

</div>
