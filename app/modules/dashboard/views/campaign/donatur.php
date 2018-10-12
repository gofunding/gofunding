<?php

use app\messages\text;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\dashboard\models\search\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $judulCampaign;
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => '/dashboard/'];
$this->params['breadcrumbs'][] = ['label' => 'Campaign', 'url' => '/dashboard/campaign/index'];
// $this->params['breadcrumbs'][] = ['label' => 'List Donatur'];
$this->params['breadcrumbs'][] = ['label' => $judulCampaign];
$this->params['title'] = 'List' . $this->title;

$gridColumns = [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => 'No',
        'contentOptions' => ['class' => 'text-center'],
    ],
    [
        'label' => 'Nama Donatur',
        'attribute' => 'user_id',
        'format' => 'raw',
        'value' => function ($data) {
            return $data['donasi']['is_anonim'] == 1 ? 'Anonim' : $data['user']['nama_lengkap'];
        }
    ],
    'nominal_donasi',
    'biaya_administrasi',
    'donasi_bersih',
    'created_at:date'
];

$fullExportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_CSV => false,
            ExportMenu::FORMAT_EXCEL => false,
            ExportMenu::FORMAT_PDF => false,
        ],
        'filename' => 'Laporan Donatur Campaign ' . $judulCampaign,
        'fontAwesome' => true,
        'pjaxContainerId' => 'kv-pjax-container',
        'target' => ExportMenu::TARGET_BLANK,
        'batchSize' => 10,
        'showColumnSelector' => false,
        'asDropdown' => true,
        'dropdownOptions' => [
            'title' => Yii::t('app', 'Download Laporan'),
            'label' => Yii::t('app', 'Download Laporan'),
            'class' => 'btn btn-success btn-sm',
        ],
        'stream' => true, // this will automatically save file to a folder on web server
//            'afterSaveView' => '_view', // this view file can be overwritten with your own that displays the generated file link
        'folder' => '@webroot/runtime/export', // this is default save folder on server
        'linkPath' => '/runtime/export', // the web accessible location to the above folder
    ]);

?>
<br>
<div class="panel">
    <div class="campaign-index panel-body">
        <?= \app\widgets\adminlte\Menu::widget(\app\modules\dashboard\components\Menus::getMenuCampaignTab()); ?>
        <p>
        <div class="pull-right">
            <?= \app\widgets\PageSize::widget(['id' => 'select_page']); ?>
        </div>

        <?= $fullExportMenu ?>

        </p>
        <div class = "clearfix"></div>
        <div class = "table-responsive">
            <?php Pjax::begin(['id' => 'grid'])

            ?>
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
                        'class' => 'yii\grid\CheckboxColumn',
                        'name' => 'select',
                    ],
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'No',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
//                    'campaign.judul_campaign',
                    [
                        'label' => 'Nama Donatur',
                        'attribute' => 'user_id',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data['donasi']['is_anonim'] == 1 ? 'Anonim' : $data['user']['nama_lengkap'];
                        }
                    ],
                    [
                        'attribute' => 'nominal_donasi',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Yii::$app->formatter->asCurrency($data['nominal_donasi']);
                        }
                    ],
                    [
                        'attribute' => 'biaya_administrasi',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Yii::$app->formatter->asCurrency($data['biaya_administrasi']);
                        }
                    ],
                    [
                        'attribute' => 'donasi_bersih',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Yii::$app->formatter->asCurrency($data['donasi_bersih']);
                        }
                    ],
                ],
            ]);

            ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>