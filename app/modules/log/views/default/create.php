<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\log\models\Login */

$this->title = Yii::t('app', 'Tambah Login');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Login'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="login-create">

    <h1><?php Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
