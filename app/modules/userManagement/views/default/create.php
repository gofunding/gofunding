<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\User */

$this->title = 'Tambah';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create box">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
