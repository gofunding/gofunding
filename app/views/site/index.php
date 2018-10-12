<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\bootstrap\Carousel;

$this->title = Yii::$app->params['brand'];

$formatter = Yii::$app->formatter;
?>

<div id="site-index">
    <!-- SECTION 1 -->
    <div class="section-1 jumbotron main-banner">
        <div class="banner-overlay"></div>
        <div class="banner-text">
            <div class="container">
                <h2>Galang dana online untuk</h2>
                <div class="text-capitalize">
                    <span class="typed text-50"></span>
                </div>
                <p>Ajak keluarga, teman dan netizen <br> berdonasi secara transparan dengan <?= Yii::$app->params['brand'] ?></p>
            </div>
        </div>
        <div class="row">
            <div class="banner-stats">
                <div class="container">
                    <div class="col-md-4">
                        <div class="banner-stats-content">
                            <div class="title"><?= $reached ?></div>
                            <div class="sub-title">Campaign Tercapai</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="banner-stats-content">
                            <div class="title"><?= !empty($sumDonasi) ? $formatter->asCurrency($sumDonasi) : 0 ?></div>
                            <div class="sub-title">Donasi Terkumpul</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="banner-stats-content">
                            <div class="title"><?= $sumUsers ?></div>
                            <div class="sub-title">#OrangBaik Tergabung</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2 -->
    <div class="section-2">
        <div class="container margin-bottom-20">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="text-32">Menghubungkan <br> #OrangBaik</h2>
                    <p class="text-18">Cerita sukses penggalangan dana di <?= Yii::$app->params['brand'] ?></p>
                    <p><a class="btn btn-success text-16" href="<?= Url::to(['/campaign/create']) ?>">Mulai Galang Dana</a></p>
                </div>
                <div class="col-md-8 col-md-offset-1">
                    <div class="owl-carousel owl-theme">
                        <?php foreach (Yii::$app->db->createCommand("SELECT `path` FROM banner WHERE is_active=1 ORDER BY `order` ASC LIMIT 5")->queryAll() as $banner) { ?>
                            <div class="item"><h4><img src="<?= Yii::$app->helpers->displayImage('banner', $banner['path']) ?>"></h4></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3 -->
    <div class="section-3">
        <div class="container text-center">
            <div class="row">
                <div class="text-32 title">Platform galang dana terpercaya</div>
                <div class="sub-title">Ribuan orang menggalang dana di <?= Yii::$app->params['brand'] ?> setiap harinya</div>

                <?php foreach ($campaign as $key => $value) { ?>
                    <?php $progress = $formatter->asPercent($value['terkumpul'] / $value['target_donasi']); ?>
                    <div class="campaign-card">
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <a href="<?= Url::to(['/campaign/view', 'id' => $value['id']]) ?>">
                                    <img src="<?= Yii::$app->helpers->displayImage('campaign', $value['cover_image']) ?>" class="img-responsive" alt="Responsive image">
                                    <div class="campaign-body">
                                        <p class="text-18 text-semibold campaign-card-title"><?= $value['judul_campaign'] ?></p>
                                        <p class="campaign-card-sub-title">
                                            <?= $value['nama_lengkap'] ?> 
                                            <?php
                                            if ($value['is_community'] == 2) {
                                                echo '<span class="label label-primary"> ORG </span>';
                                            }
                                            ?>
                                        </p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progress ?>"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-6 text-left">
                                                <p>Target</p>
                                                <p><?= $formatter->asCurrency($value['target_donasi']) ?></p>
                                            </div>
                                            <div class="col-xs-6 text-right">
                                                <p>Sisa hari</p>
                                                <p><?= $value['deadline'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <p class="text-center"><a class="btn btn-success text-16" href="<?= Url::to(['/campaign/index']) ?>">View More</a></p>
        </div>
    </div>

    <!-- SECTION 4 -->
    <div class="section-4">
        <div class="container">
            <div class="text-32 title text-center">Kenapa galang dana dengan <?= Yii::$app->params['brand'] ?>?</div>
            <div class="col-md-6 text-right">
                <img src="<?= Yii::$app->params['publicUrl'] . 'images/why-gofunding.png' ?>">
            </div>
            <div class="row">
                <div class="col-md-4 text-left">
                    <ul>
                        <li><strong>Cepat,</strong> buat halaman campaign dalam 5 menit</li>
                        <li><strong>Transparan,</strong> donasi tercatat real-time dan bisa dilihat siapa saja</li>
                        <li><strong>Mudah,</strong> terima donasi via transfer bank dan kartu kredit</li>
                        <li><strong>Fleksibel,</strong> cairkan donasi kapan saja</li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="text-center"><a class="btn btn-success text-16" href="<?= Url::to(['/campaign/create']) ?>">Mulai Galang Dana</a></p>
    </div>
</div>

</div>

<?php
$js = <<<JS

// Typed
    var typed = new Typed('.typed', {
        strings: ["Menolong Sesama", "Biaya Pengobatan", "Bikin Karya", "Bangun Indonesia", "Orang Tersayang"],
        typeSpeed: 120,
        backSpeed: 50,
        fadeOut: true,
        loop: true
    });

// Owl Carousel
    $('.owl-carousel').owlCarousel({
        loop:true,
        autoplay: true,
        autoplayTimeout: 3000,
        nav:true,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        responsive:{
            1:{
                items:1
            },
        }
    })

JS;
$this->registerJs($js);
?>