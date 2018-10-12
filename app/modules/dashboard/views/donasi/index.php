<?php

use app\messages\text;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\Donasi;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\dashboard\models\search\DonasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Donasi');
// $this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => '/dashboard/'];
// $this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = 'List' . $this->title;
?>
<br>
<div class="panel">
    <div class="donasi-index panel-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
        <p>
        <div class="pull-right">
            <?= \app\widgets\PageSize::widget(['id' => 'select_page']); ?>
        </div>
        <div class="clearfix"></div>
        <div class="table-responsive">
            <?php Pjax::begin(['id' => 'grid']) ?>
            <?=
            GridView::widget([
                'id' => 'gridView',
                'emptyText' => Yii::t('app', 'Data tidak ditemukan'),
                //'summary'=>'',
                //'showFooter'=>true,
                //'filterPosition'=>'', // bisa header, footer or body
                'filterSelector' => 'select[name="per-page"]',
                'showHeader' => true,
                'showOnEmpty' => true,
                'emptyCell' => '',
                'tableOptions' => ['class' => 'table table-bordered table-condensed table-hover'],
                'layout' => '{summary}{items}<div class="text-center">{pager}</div>',
                'pager' => [
                    'options' => ['class' => 'pagination'], // set clas name used in ui list of pagination
                    'prevPageLabel' => Yii::t('app', 'Previous'), // Set the label for the "previous" page button
                    'nextPageLabel' => Yii::t('app', 'Next'), // Set the label for the "next" page button
                    'firstPageLabel' => Yii::t('app', 'First'), // Set the label for the "first" page button
                    'lastPageLabel' => Yii::t('app', 'Last'), // Set the label for the "last" page button
                    'nextPageCssClass' => 'next', // Set CSS class for the "next" page button
                    'prevPageCssClass' => 'prev', // Set CSS class for the "previous" page button
                    'firstPageCssClass' => 'first', // Set CSS class for the "first" page button
                    'lastPageCssClass' => 'last', // Set CSS class for the "last" page button
                    'maxButtonCount' => 10, // Set maximum number of page buttons that can be displayed
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                        ['class' => 'yii\grid\CheckboxColumn',
                        'name' => 'select',
                    ],
                        ['class' => 'yii\grid\SerialColumn',
                        'header' => 'No',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                        [
                        'label' => 'Order ID',
                        'attribute' => 'id',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data['id'];
                        }
                    ],
                        [
                        'attribute' => 'judul_campaign',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data['campaign']['judul_campaign'];
                        }
                    ],
                    // 'user_id',
                    // 'kode_unik',
                    [
                        'attribute' => 'nominal_donasi',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Yii::$app->formatter->asCurrency($data['nominal_donasi']);
                        }
                    ],
                        [
                        'filter' => \kartik\date\DatePicker::widget([
                            'model' => $searchModel,
                            'name' => 'tanggal_donasi',
                            'attribute' => 'tanggal_donasi',
                            'language' => 'en',
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy',
                            ]
                        ]),
                        'attribute' => 'tanggal_donasi',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Yii::$app->formatter->asDatetime($data['tanggal_donasi']);
                        }
                    ],
                        [
                        'filter' => Donasi::getStatus(),
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Donasi::getStatus($data['status']);
                        }
                    ],
                            [
//                        'filter' => Html::dropDownList(Donasi::getStatus(), ['prompt' => '--- select ---']),
                        'filter' => '',
                        'label' => 'Bukti Pembayaran',
                        'attribute' => 'upload_bukti_transaksi',
                        'format' => 'raw',
                        'value' => function($data) {
                            if (!empty($data['upload_bukti_transaksi']) && $data['bank']['nama_payment'] == 'manual_bank_transfer') {
                                return '<a data-pjax="0" target="_blank" href="' . Url::to(Yii::$app->params['uploadUrl']) . 'bukti_transaksi/' . $data['upload_bukti_transaksi'] . '">Lihat file</a>';
                            }
                        }
                    ],
                    // 'tanggal_donasi',
                    // 'status',
                    // 'is_anonim',
                    // 'komentar',
                    // 'phone_penerima_sms',
                    // 'bank_id',
                    // 'transfer_sebelum',
                    // 'created_at',
                    // 'updated_at',
                    // 'created_by',
                    // 'updated_by',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width:90px;', 'class' => 'text-center'],
                        'template' => '{cara-pembayaran}',
                        'header' => Yii::t('app', 'Options'),
                        'buttons' => [
                            'cara-pembayaran' => function ($url, $model) {
                                if ($model['status'] == 1) {
                                    if (date('Y-m-d H:i:s') < $model['transfer_sebelum'] && $model['bank']['nama_payment'] !== 'manual_bank_transfer') {
                                        $icon = '<span class="btn btn-sm btn-info"><i class=""></i> Bayar Sekarang</span>';
                                        $url = ['/campaign/contributesummary', 'id' => $model['id'], 'campaignId' => $model['campaign_id']];
                                        return Html::a($icon, $url, [
//                                            'title' => Yii::t('app', 'Cara Pembayaran'),
                                                    'url' => $url,
                                                    'data-pjax' => 0,
                                                    'target' => '_blank'
                                        ]);
                                    } elseif ($model['status'] == 1 && $model['bank']['nama_payment'] == 'manual_bank_transfer') {
                                        $icon = '<span class="btn btn-sm btn-primary"><i class=""></i> Konfirmasi Donasi</span>';
                                        $url = ['/campaign/confirmation-payment', 'id' => $model['id'], 'campaignId' => $model['campaign_id']];
                                        return Html::a($icon, $url, [
//                                            'title' => Yii::t('app', 'Cara Pembayaran'),
                                                    'url' => $url,
                                                    'data-pjax' => 0,
                                                    'target' => '_blank'
                                        ]);
                                    } else {
                                        return '<span class="label label-danger">Kadaluarsa</label>';
                                    }
                                }
                            },
                        ],
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>
<?php
$url = Url::to(['delete-items']);
$js = <<< JS
$(document).on("click","#btn-deletes", function() {
if(confirm("Apakah Anda yakin ingin menghapus item ini ?")){
var keys = $("#gridView").yiiGridView("getSelectedRows");
$.ajax({
type: "post",
url: '$url',
data: {keys},
success: function(data) {
$.pjax.reload({container:"#grid"});
},
});
return false;
};
});
$(document).on('click', '.btn-tambah',function(e){
var url = $(this).attr("href");
$("#modalform").modal("show")
.find("#modalContent")
.load( url);
$('.modal-title').text("judul modal ");
e.preventDefault();
});
;
JS;
$this->registerJs($js);
?>
<?php
// Modal::begin([
//   //'size'=> 'modal-lg',
//   'id' => 'modalform',
//   'options'=>['class'=> 'modal fade'],
//   'header' => '<h4 class="text-center modal-title">Create</h4>',]);
// echo '<div id="modalContent"></div>';
// Modal::end();
?>

