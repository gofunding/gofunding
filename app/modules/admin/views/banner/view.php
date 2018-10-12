<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banner'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="banner-view panel panel-default">
    <div class="panel-heading">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="panel-body">
        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'id'
                [
                    'attribute' => 'path',
                    'format' => 'raw',
                    'value' => '<img style="width: 100%" src="' . Yii::$app->helpers->displayImage('banner', $model['path']) . '">'
                ],
                'order',
                [
                    'attribute' => 'is_active',
                    'value' => Yii::$app->globalFunction->isActive($model['is_active'])
                ]
            ],
        ])
        ?>
    </div>

</div>