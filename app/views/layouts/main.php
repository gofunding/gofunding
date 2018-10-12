<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="icon" type="image/x-icon" href="<?= Yii::$app->params['publicUrl'].'images/favicon.ico' ?>" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?= $this->render('header') ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?php
                    if (Yii::$app->session->hasFlash('success') || Yii::$app->session->hasFlash('warning') || Yii::$app->session->hasFlash('danger')) :
                        echo app\widgets\toastr\ToastrFlash::widget([
                            'options' => [
                                "closeButton" => false,
                                "debug" => false,
                                "newestOnTop" => false,
                                "progressBar" => true,
                                "positionClass" => "toast-top-right",
                                "preventDuplicates" => false,
                                "onclick" => null,
                                "showDuration" => "300",
                                "hideDuration" => "1000",
                                "timeOut" => "10000",
                                "extendedTimeOut" => "1000",
                                "showEasing" => "swing",
                                "hideEasing" => "linear",
                                "showMethod" => "fadeIn",
                                "hideMethod" => "fadeOut"
                              ]
                        ]);
                    endif;
                ?>
                <?= $content ?>
            </div>
        </div>

        <?= $this->render('footer') ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
