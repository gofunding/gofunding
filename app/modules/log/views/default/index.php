<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
//use yii\grid\GridView;
use kartik\grid\GridView;
use app\components\Buttons;
use app\messages\text;
use app\components\GlobalFunction;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\log\models\LoginSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Log ' . Yii::t('app', Yii::$app->controller->id);
$this->params['breadcrumbs'][] = 'Log Aplikasi';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$selectColumns = [
    [
	'class' => 'yii\grid\SerialColumn',
	'header' => 'No',
	'contentOptions' => ['class' => 'text-center'],
    ],
//                    'id',
//                    'log_id',
    [
	'attribute' => 'date',
	'filterType' => GridView::FILTER_DATE_RANGE,
	'filterWidgetOptions' => [
	    'pluginOptions' => [
		'locale' => ['format' => 'D-MMM-Y', 'separator' => ' s/d '],
		'convertFormat' => true,
		'autoWidget' => true,
		'autoclose' => true,
		'todayHighlight' => true,
	    ]
	],
//        'filter' => \kartik\daterange\DateRangePicker::widget([
//            'useWithAddon' => true,
//            'convertFormat' => true,
//            'initRangeExpr' => true,
//            'pluginOptions' => [
//                'placeholder' => 'te',
//                'locale' => ['format' => 'd-M-Y', 'separator' => ' s/d '],
//                'ranges' => [
////                                Yii::t('app', "Today") => ["moment().startOf('day')", "moment()"],
//                    Yii::t('app', "Yesterday") => ["moment().startOf('day').subtract(1,'days')", "moment().endOf('day').subtract(1,'days')"],
//                    Yii::t('app', "Last {n} Days", ['n' => 7]) => ["moment().startOf('day').subtract(6, 'days')", "moment()"],
//                    Yii::t('app', "Last {n} Days", ['n' => 30]) => ["moment().startOf('day').subtract(29, 'days')", "moment()"],
//                    Yii::t('app', "This Month") => ["moment().startOf('month')", "moment().endOf('month')"],
//                    Yii::t('app', "Last Month") => ["moment().subtract(1, 'month').startOf('month')", "moment().subtract(1, 'month').endOf('month')"],
//                ]
//            ],
//            'options' => [
//                'class' => 'form-control',
//                'placeholder' => '--- Pilih Tanggal ---',
////                'value' => $tanggal_masuk,
//            ],
//        ]),
	'format' => 'raw',
	'value' => function ($data) {
	    return Yii::$app->formatter->asDatetime($data['date']);
	}
    ],
    'username',
    'ip',
    'os_device',
    [
	'attribute' => 'status',
	'filter' => GlobalFunction::getLogStatus(),
	'format' => 'raw',
	'value' => function ($data) {
	    return GlobalFunction::getLogStatus($data['status']);
	}
    ],
    'desc'
];
?>
<?php Pjax::begin(['id' => 'grid']) ?>
<div class="nav-tabs-custom">
    <?= \app\widgets\adminlte\Menu::widget(app\modules\log\components\Menus::getMenuTab()) ?>
    <div class="login-index box-body">
	<?php // echo $this->render('_search', ['model' => $searchModel]);     ?>
        <p>
	    <?= Yii::$app->helpersLogs->buttonExport('Log Login', $dataProvider, $selectColumns, $searchModel) ?>
        <div class="pull-right">
	    <?= \app\widgets\PageSize::widget(['id' => 'select_page']); ?>
        </div>
        </p>
        <div class="clearfix"></div>
        <div class="table-responsive">

	    <?=
	    GridView::widget([
		'id' => 'gridView',
		'emptyText' => 'Data tidak ada',
		//'summary'=>'',
		//'showFooter'=>true,
		//'filterPosition'=>'', // bisa header, footer or body
		'filterSelector' => 'select[name="per-page"]',
		'showHeader' => true,
		'showOnEmpty' => true,
		'responsiveWrap' => false,
		'emptyCell' => '',
		'tableOptions' => ['class' => 'table table-bordered table-condensed table-hover'],
		'pager' => Buttons::pager(),
		'layout' => '{summary}{items}<div class="text-center">{pager}</div>',
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => $selectColumns,
//                'columns' => [
//                    ['class' => 'yii\grid\CheckboxColumn',
//                        'name' => 'select'
//                    ],
//                    ['class' => 'yii\grid\SerialColumn',
//                        'header' => 'No',
//                        'contentOptions' => ['class' => 'text-center'],
//                    ],
////                    'id',
////                    'log_id',
//                    [
//                        'attribute' => 'date',
//                        'filterType' => GridView::FILTER_DATE,
//                        'filterWidgetOptions' => [
//                            'pluginOptions' => [
//                                'format' => 'dd-M-yyyy',
//                                'autoWidget' => true,
//                                'autoclose' => true,
//                                'todayHighlight' => true
//                            ]
//                        ],
//                        'format' => 'raw',
//                        'value' => function ($data) {
//                            return Yii::$app->formatter->asDatetime($data['date']);
//                        }
//                    ],
//                    'username',
//                    'ip',
//                    'os_device',
//                    [
//                        'attribute' => 'status',
//                        'filter' => GlobalFunction::getLogStatus(),
//                        'format' => 'raw',
//                        'value' => function ($data) {
//                            return GlobalFunction::getLogStatus($data['status']);
//                        }
//                    ],
//                    'desc',
//                    'data_json',
		    /* [
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
		      ]);
		      },
		      'update' => function ($url, $model) {
		      $icon = '<span class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></span>';
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
		      ], */
//                ],
	    ]);
	    ?>

        </div>
    </div>
</div>
<?php Pjax::end() ?>
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

