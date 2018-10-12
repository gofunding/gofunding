<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\administrator\models\User */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Management'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update box">
    
    <?=
    $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
    ])
    ?>

</div>
