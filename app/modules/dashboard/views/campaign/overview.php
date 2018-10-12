<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */

$this->title = $model['judul_campaign'];
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => '/dashboard/'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaign'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$formatter = Yii::$app->formatter;

?>

<br>
<div class="campaign-view panel panel-body">
    <?= \app\widgets\adminlte\Menu::widget(\app\modules\dashboard\components\Menus::getMenuCampaignTab()); ?>
    <h1 class="text-center"><?= Html::encode($model['judul_campaign']) ?></h1>
</div>

<div class="panel panel-body">
    <div class="row">
        <div class="col-xs-12">
            <div class="text-left">
                <h4><b>Total <?= $model['total_donatur'] ?> Donatur</b></h4>
                <!--<span style=""><i class="glyphicon glyphicon-heart fa-2x"></i></span>-->
                <!--<h3>1</h3>-->
                <!--<h4>Donatur</h4>-->
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <br>
            <h4 class="text-center"><b>Rincian Donasi</b></h4>
            <hr>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Total Donasi Terkumpul</td>
                            <td>Rp</td>
                            <td><?= !empty($model['total_donasi_terkumpul']) ? $formatter->asDecimal($model['total_donasi_terkumpul']) : '0' ?></td>
                        </tr>
                        <tr>
                            <td><p>Biaya Operasional <?= Yii::$app->params['brand'] ?>, <br>
                                    Biaya administrasi 5% dari total donasi online</p>
                            </td>
                            <td>Rp</td>
                            <td><?= $formatter->asDecimal($biayaAdministrasi) ?> (-)</td>
                        </tr>
                        <tr>
                            <td>
                                <h3><b>Total Donasi Bersih</b></h3>
                            </td>
                            <td><h3><b>Rp</b></h3></td>
                            <td><h3><b><?= $formatter->asDecimal($totalDonasiBersih) ?></b></h3></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>