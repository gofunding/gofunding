<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\components\Buttons;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\log\models\search\SqlError */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Log Sql Errors');
$this->params['breadcrumbs'][] = $this->title;


$selectColumns = [
//    ['class' => 'yii\grid\SerialColumn'],
    'id',
    'sql_text:ntext',
    'object_name',
    'error_number',
    'row_count',
    'sql_state',
    'error_message:ntext',
    'description:ntext',
    [
	'attribute' => 'created_at',
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
	'value' => function($data) {
	    return Yii::$app->formatter->asDatetime($data['created_at']);
	}
    ],
    'created_by',
];
?>

<?php Pjax::begin(['id' => 'grid']) ?>
<div class="nav-tabs-custom">
    <?= \app\widgets\adminlte\Menu::widget(app\modules\log\components\Menus::getMenuTab()) ?>
    <div class="log-sql-error-index box-body">
        <p>
	    <?= Yii::$app->helpersLogs->buttonExport('Log SQL Error', $dataProvider, $selectColumns, $searchModel) ?>
        <div class="pull-right">
	    <?= \app\widgets\PageSize::widget(['id' => 'select_page']); ?>
        </div>
        </p>
        <div class="clearfix"></div>
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
	]);
	?>      
    </div>
</div>

<?php Pjax::end() ?>