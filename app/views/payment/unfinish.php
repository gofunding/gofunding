<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Payment ' . $response;
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'Pembayaran Belum Selesai';

?>

<?php if ($response == 'success') { ?>

    <div class="site-contact">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

        <div class="text-center">
            <h1>
                Silahkan selesaikan pembayaran Anda. <br><br>
                Anda bisa masuk ke menu Dashboard -> Donasi Saya, dan selesaikan pembayaran.
            </h1>
        </div>
    </div>

<?php } else { ?>
    <div class="site-contact">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

        <div class="text-center">
            <h1>
                Payment gagal, silahkan hubungi kami di email: haifahrul@gmail.com
            </h1>
        </div>
    </div>    
<?php } ?>