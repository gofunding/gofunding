<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\log\components;

/**
 * Description of Helpers
 *
 * @author haifahrul
 */
use kartik\export\ExportMenu;
use Yii;

class HelpersLogs {

    public function buttonExport($nameFile, $dataProvider, $selectColumns, $searchModel) {

        return ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $selectColumns,
                    'filterModel' => $searchModel,
                    'exportConfig' => [
                        ExportMenu::FORMAT_TEXT => false,
                        ExportMenu::FORMAT_HTML => false,
                        ExportMenu::FORMAT_CSV => false,
                        ExportMenu::FORMAT_EXCEL => false,
                    ],
                    'filename' => $nameFile . ' - ' . date('d-M-Y (H.i.s)'),
                    'fontAwesome' => true,
                    'pjaxContainerId' => 'kv-pjax-container',
                    'target' => ExportMenu::TARGET_BLANK,
                    'batchSize' => 10,
                    'asDropdown' => true,
                    'dropdownOptions' => [
                        'title' => Yii::t('app', 'Export'),
                        'label' => Yii::t('app', 'Export'),
                        'class' => 'btn btn-default',
                    ],
                    'stream' => true, // this will automatically save file to a folder on web server
                    //            'afterSaveView' => '_view', // this view file can be overwritten with your own that displays the generated file link
                    'folder' => '@webroot/runtime/export/logs', // this is default save folder on server
                    'linkPath' => '/runtime/export', // the web accessible location to the above folder
        ]);
    }

}
