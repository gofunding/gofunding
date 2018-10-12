<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Campaigns');
$this->params['breadcrumbs'][] = $this->title;
$formatter = Yii::$app->formatter;
?>

<div class="campaign-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <hr>
    <!-- SECTION 3 -->
    <div class="section-3">
        <div class="container text-center">
            <div class="row">
                <?php foreach ($model as $key => $value) { ?>
                <div class="col-md-4">
                    <div class="thumbnail">
                    <a href="<?= Url::to(['#']) ?>">
                            <img src="<?= Yii::$app->params['campaignImage'] ?>/1.png" class="img-responsive" alt="Responsive image">
                            <p><?= $value['judul_campaign'] ?></p>
                            <p><?= $value['nama_lengkap'] ?></p>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 text-left">
                                    <p>Terkumpul</p>
                                    <p><?= $formatter->asCurrency($value['target_donasi']) ?></p>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <p>Sisa hari</p>
                                    <p><?= $value['deadline'] ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <p>
        <?php // Html::a(Yii::t('app', 'Create Campaign'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php /*Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'judul_campaign',
            'target_donasi',
            'link',
            // 'deadline',
            // 'kategori_id',
            // 'lokasi_id',
            // 'cover_image',
            // 'video_url:url',
            // 'deskripsi_singkat',
            // 'deskripsi_lengkap:ntext',
            // 'is_agree',
            // 'is_active',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */?>
    <?php //Pjax::end(); ?>
</div>