<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */

$this->title = $model->judul_campaign;
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => '/dashboard/'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaign'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$formatter = Yii::$app->formatter;

?>
<br>
<div class="campaign-update panel">
    <div class="panel-body">
<?= \app\widgets\adminlte\Menu::widget(\app\modules\dashboard\components\Menus::getMenuCampaignTab()); ?>
        <h1 class="text-center"><?= Html::encode($model->judul_campaign) ?></h1>
        <hr>
        <?=
        $this->render('_form', [
            'model' => $model,
        ])

        ?>
    </div>
</div>
