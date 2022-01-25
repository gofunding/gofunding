<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */

$this->title = $model->judul_campaign;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaign'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$formatter = Yii::$app->formatter;
?>

<div class="campaign-view">
    <!--<p>
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
    </p> -->

    <?php if ($model->is_active == 5) { ?>
        <div class="alert alert-info" role="alert"> 
            <strong>Mohon menunggu,</strong> campaign Anda sedang kami review.
        </div>
    <?php } ?>

    <h1 class="text-center"><?= Html::encode($model->judul_campaign) ?></h1>
    <br>
    <div class="row">
        <div class="col-md-7">
            <div class="campaign-view-cover text-center">
                <img style="width:100%" src="<?= Yii::$app->helpers->displayImage('campaign', $model['cover_image']) ?>" class="img-responsive-" alt="Responsive image">
            </div>
            <h4><?= Html::encode($model->deskripsi_singkat) ?></h4>
            <div class="row">
                <!-- <div class="col-xs-2">
                    <img src="<?= Yii::$app->helpers->displayImage('campaign', $model['cover_image']) ?>" class="img-responsive" alt="Responsive image">
                </div> -->
                <div class="col-xs-10">
                    <p>Campaigner</p>
                    <p><strong><?= $model->userProfile->nama_lengkap ?></strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <h2><?= Html::encode($formatter->asCurrency($model->terkumpul)) ?></h2>
                    <p>terkumpul dari target <?= Html::encode($formatter->asCurrency($model->target_donasi)) ?> </p>
                    <div class="progress">
                        <?php
                        $initProgress = $model['terkumpul'] / $model['target_donasi'];
                        $progress = $formatter->asPercent($initProgress);
                        $percent = $initProgress * 100 <= 100 ? $progress : '100%';
                        ?>
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= Html::encode($progress); ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 text-left">
                            <p><strong><?= $percent ?></strong> terkumpul</p>
                        </div>
                        <div class="col-xs-6 text-right">
                            <p><i class="fa fa-clock-o"></i> <strong><?= Html::encode($model['deadline']) ?></strong> hari lagi</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="<?= Url::to(['/campaign/contribute', 'id' => $model->id]) ?>">
                                <div class="btn-group btn-group-justified" role="group" aria-label="">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-info">Donasi Sekarang</button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <div class="desc-long">
                <p>
                    <?= Html::encode($model->deskripsi_lengkap) ?>
                </p>
            </div>
            <br>
            <blockquote>
                <p><a href="<?= Url::to(Yii::$app->params['uploadUrl'] . 'campaign/proposal/') . $model->upload_file ?>" target="_blank">Download Proposal</a></p> <br>
                Disclaimer: Informasi dan opini yang tertulis di halaman ini adalah milik campaigner dan tidak mewakili Kami
            </blockquote>
        </div>
        <div class="col-md-4">
            <h3>Donatur (<?= Html::encode($jumlahDonatur) ?>)</h3>
            <?php foreach ($donatur as $k => $v) { ?>
                <div class="col-md-2">
                    <img  width="50" src="<?= $v['is_anonim'] == 1 ? Yii::$app->params['defaultImage'] : Yii::$app->helpers->displayImage('avatar', Yii::$app->user->identity->userProfile->avatar) ?>">
                </div>
                <div class="col-md-10">
                    <h4><?= $formatter->asCurrency($v['nominal_donasi']) ?></h4>
                    <p><strong><?php echo $v['is_anonim'] == 1 ? '<strong>Anonim</strong>' : Html::encode($v['nama_lengkap']) ?></strong></p>
                    <p><?= Html::encode($formatter->asDate($v['tanggal_donasi'])) ?></p>
                    <p><?= Html::encode($v['komentar']) ?></p>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php /* DetailView::widget([
      'model' => $model,
      'attributes' => [
      'id',
      'user_id',
      'judul_campaign',
      'target_donasi',
      'link',
      'deadline',
      'kategori_id',
      'lokasi_id',
      'cover_image',
      'video_url:url',
      'deskripsi_singkat',
      'deskripsi_lengkap:ntext',
      'is_agree',
      'is_active',
      'created_at',
      'updated_at',
      'created_by',
      'updated_by',
      ],
      ]) */ ?>

</div>
