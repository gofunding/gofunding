<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */

$this->title = Yii::t('app', 'Tambah Banner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banner'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="banner-create panel panel-default">

    <div class="panel-heading">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>

    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
            'bannerUpload' => $bannerUpload
        ]) ?>
    </div>

</div>
