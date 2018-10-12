<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use app\messages\text;
use app\models\Donasi;
use app\models\Bank;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\DonasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Donasis');
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = 'List' . $this->title;
?>
<div class="panel">
    <div class="panel-body donasi-index">
        <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
        <p>
        <div class="pull-right">
            <?=
            \app\widgets\PageSize::widget([
                'id' => 'select_page'
            ]);
            ?>
        </div>
        </p>
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
                        [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'No',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
//                    'id',
//                    'campaign_id',
//                    'user:firstname',
                    [
                        'label' => 'Campaign',
                        'attribute' => 'campaign_id',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data['campaign']['judul_campaign'];
                        }
                    ],
                        [
                        'label' => 'Nama Donatur',
                        'attribute' => 'user_id',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data['userProfile']['nama_lengkap'];
                        }
                    ],
                        [
                        'label' => 'Bank Tujuan',
                        'attribute' => 'bank_id',
                        'format' => 'raw',
                        'value' => function($data) {
                            if ($data['bank']['nama_payment'] == 'manual_bank_transfer') {
                                return $data['bank']['nama_bank'] . Bank::getVaNumber($data['bank']['va_number']);
                            } else {
                                return $data['bank']['nama_bank'];
                            }
                        }
                    ],
                    'nominal_donasi:currency',
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
                    // 'is_anonim',
                    // 'komentar',
                    // 'phone_penerima_sms',
                    // 'bank_id',
                    // 'transfer_sebelum',
                    // 'signature_key:ntext',
                    // 'created_at',
                    // 'updated_at',
                    // 'created_by',
                    // 'updated_by',
                    // 'order_id',
                    // 'kode_unik',
                    // 'upload_bukti_transaksi',
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
                        [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width:90px;', 'class' => 'text-center'],
                        'template' => '{view} {approve}',
                        'header' => Yii::t('app', 'Options'),
                        'buttons' => [
                            'view' => function ($url, $model) {
                                $icon = '<span class="btn btn-sm btn-default"><i class="fa fa-search-plus"></i></span>';
                                $url = ['view', 'id' => $model['id']];

                                return Html::a($icon, $url, [
                                            'title' => Yii::t('app', 'View'),
                                            'url' => $url,
                                            'id' => 'btn-view',
                                            'data-pjax' => 0,
                                ]);
                            },
                            'approve' => function ($url, $model) {
                                $icon = '<span class="btn btn-sm btn-success"><i class="fa fa-check"></i></span>';
                                $url = ['approve', 'id' => $model['id']];

                                if ($model['status'] == 4 && (!empty($model['upload_bukti_transaksi']) || $model['bank']['nama_payment'] == 'manual_bank_transfer')) {
                                    return Html::a($icon, $url, [
                                                'title' => 'Approve Pembayaran',
                                                'url' => $url,
                                                'id' => 'btn-update',
                                                'data' => [
                                                    'confirm' => 'Apakah Anda yakin akan memproses pembayaran ini?. Jika dilanjutkan nominal donasi tersebut akan ditambahkan ke donasi campaign bersangkutan.',
                                                    'method' => 'post',
                                                ],
                                                'data-pjax' => 0,
                                    ]);
                                }
                            },
                        ]
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>
