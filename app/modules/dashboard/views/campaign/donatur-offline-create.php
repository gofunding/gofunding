<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DonaturOffline */

$this->title = $judulCampaign;
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaign'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'Tambah Donatur Offline';
$this->params['title'] = $this->title;
?>
    <br>
    <div class="donatur-offline-create panel">
        <div class="panel-body">
            <?= \app\widgets\adminlte\Menu::widget(\app\modules\dashboard\components\Menus::getMenuCampaignTab()); ?>
                <h1 class="text-center">
                    <?php echo Html::encode($this->title) ?>
                </h1>

                <?= $this->render('donatur-offline-form', [
        'model' => $model,
    ]) ?>
        </div>
    </div>