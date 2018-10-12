<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use app\messages\text;
use app\models\Bank;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Bank');
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = 'List' . $this->title;

?>
<div class="panel panel-body">
    <?= \app\widgets\adminlte\Menu::widget(\app\modules\admin\components\Menus::getListTab()); ?>
    <div class="bank-index">
        <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
        <p>
        <div class="pull-right">
            <?=
            \app\widgets\PageSize::widget([
                'id' => 'select_page'
            ]);

            ?>
        </div>
        <?= Html::a('<i class="glyphicon glyphicon-plus glyphicon-sm"></i> Create ', ['create'], ['data-pjax' => 0, 'class' => 'btn btn-primary btn-sm btn-tambah1'])

        ?>
        <?= Html::button('<span class="glyphicon glyphicon-remove glyphicon-sm"></span> Delete', ['data-pjax' => 0, 'class' => 'btn btn-danger btn-sm', 'title' => 'hapus', 'id' => 'btn-deletes'])

        ?>
        &nbsp&nbsp&nbsp<a href="https://snap-docs.midtrans.com/#request-body-json-parameter" target="_blank">See Doc Midtrans</a>
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
//                    ['class' => 'yii\grid\CheckboxColumn', 'name' => 'select'],
                    ['class' => 'yii\grid\SerialColumn',
                        'header' => 'No',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    // 'id',
                    [
                        'label' => 'Metode Pembayaran',
                        'attribute' => 'nama_bank',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data['nama_bank'];
                        }
                    ],
                    [
                        'label' => 'Nama Payment (Format Midtrans) ',
                        'attribute' => 'nama_payment',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data['nama_payment'];
                        }
                    ],
                    [
                        'attribute' => 'biaya_per_transaksi',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Yii::$app->formatter->asCurrency($data['biaya_per_transaksi']);
                        }
                    ],
                    [
                        'filter' => Bank::getIsActive(),
                        'label' => 'Status',
                        'attribute' => 'is_active',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Bank::getIsActive($data['is_active']);
                        }
                    ],
                    [
                        'filter' => Bank::getIsVA(),
                        'label' => 'Is VA',
                        'attribute' => 'is_va',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Bank::getIsVA($data['is_va']);
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width:90px;', 'class' => 'text-center'],
                        'template' => '{view} {update} {delete}',
                        'header' => Yii::t('app', 'Options'),
                        'buttons' => [
                            'view' => function ($url, $model) {
                                $icon = '<span class="btn btn-xs btn-default"><i class="fa fa-search-plus"></i></span>';
                                $url = ['view', 'id' => $model['id']];

                                return Html::a($icon, $url, [
                                        'title' => Yii::t('app', 'View'),
                                        'url' => $url,
                                        'id' => 'btn-view',
                                        'data-pjax' => 0,
//                            'data-toggle' => 'modal',
//                            'data-target' => '#modal-view',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                $icon = '<span class="btn btn-xs btn-default"><i class="fa fa-edit"></i></span>';
                                $url = ['update', 'id' => $model['id']];

                                return Html::a($icon, $url, [
                                        'title' => Yii::t('app', 'Update'),
                                        'url' => $url,
                                        'id' => 'btn-update',
                                        'data-pjax' => 0,
                                ]);
                            },
                            'delete' => function($url, $model) {
                                $icon = '<span class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></span>';
                                $url = ['delete', 'id' => $model['id']];

                                return Html::a($icon, $url, [
                                        'url' => $url,
                                        'title' => Yii::t('app', 'Delete'),
                                        'data' => [
                                            'confirm' => text::confirm_delete,
                                            'method' => 'post',
                                        ],
                                        'data-pjax' => 0,
                                ]);
                            }
                        ]
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

