<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
$progress = $formatter->asPercent($model->terkumpul / $model->target_donasi);
?>
<div class="campaign-card">
    <div class="col-md-4">
        <div class="thumbnail">
            <a href="<?= Url::to(['/campaign/view', 'id' => $model->id]) ?>">
                <img src="<?= Yii::$app->helpers->displayImage('campaign', $model->cover_image) ?>" class="img-responsive" alt="Responsive image">
                <div class="campaign-body">
                    <p class="text-18 text-semibold campaign-card-title"><?= $model->judul_campaign ?></p>
                    <p class="campaign-card-sub-title"><?= $model->userProfile->nama_lengkap ?></p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 text-left">
                            <p>Terkumpul</p>
                            <p><?= $formatter->asCurrency($model->terkumpul) ?></p>
                        </div>
                        <div class="col-xs-6 text-right">
                            <p>Sisa hari</p>
                            <p><?php 
                            $date1=date_create($model->deadline);
                            $date2=date_create(date('Y-m-d'));
                            $diff=date_diff($date1,$date2);
                            echo $diff->format("%a");	
                            ?></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>