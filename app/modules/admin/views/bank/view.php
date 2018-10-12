<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bank */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bank'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
 

?>
<div class="bank-view panel panel-default">

    <div class="panel-heading">
        <h3><?=  Html::encode($this->title) ?></h3>
    </div>

    <div class="panel-body">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'nama_bank',
            'nama_payment',
            [
                'attribute' => 'biaya_per_transaksi',
                'format' => 'raw',
                'value' => $model->biaya_per_transaksi
            ],
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => $model::getIsActive($model['is_active'])
            ],
            [
                'attribute' => 'is_va',
                'format' => 'raw',
                'value' => $model::getIsVA($model['is_va'])
            ],
            [
                'attribute' => 'va_number',
                'format' => 'raw',
                'value' => $model->va_number
            ],
        ],
    ]) ?>
    </div>

</div>