<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 *  created by haifahrul <haifahrul@gmail.com>
 */

namespace app\components;

use Yii;
use yii\helpers\Html;
use app\widgets\admin\components\Helper;
use app\messages\text;

class Buttons {

    public static function submitButton() {
        return Html::submitButton('<b>' . Yii::t('app', 'Simpan') . '</b>', ['class' => 'btn btn-primary btn-sm', 'title' => 'Simpan']);
    }

    public static function reset() {
        return Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['class' => 'btn btn-default btn-sm', 'title' => Yii::t('app', 'Reset Grid')]);
    }

    public static function back() {
        return Html::a('<span class="fa fa-arrow-left"></span>', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm', 'title' => Yii::t('app', 'Back')]);
//        return Html::a('<span class="fa fa-arrow-left"></span> ', ['index'], ['class' => 'btn btn-default btn-sm', 'title' => Yii::t('app', 'Back')]);
    }

    public static function cancel() {
        return Html::a('<span class=""></span> <b>' . Yii::t('app', 'Batal') . '</b>', ['index'], ['class' => 'btn btn-danger btn-sm', 'title' => Yii::t('app', 'Batal'), 'data-pjax' => true]);
    }

    public static function cancelGoBack() {
        return Html::a('<span class=""></span> <b>' . Yii::t('app', 'Cancel') . '</b>', Yii::$app->request->referrer, ['class' => 'btn btn-danger btn-sm', 'title' => Yii::t('app', 'Cancel'), 'data-pjax' => true]);
    }

    public static function prints($id) {
        if (Helper::checkRoute('print')) {
            echo Html::a("<b>" . Yii::t('app', 'Print') . "</b>", ['print', 'id' => $id], ['class' => 'btn btn-default btn-sm', 'title' => Yii::t('app', 'Print'), 'target' => '_blank']);
        }
    }

    public static function create() {
        if (Helper::checkRoute('create')) {
            return Html::a('<i class="fa fa-plus"></i> <b>' . Yii::t('app', 'Create') . '</b>', ['create'], ['data-pjax' => true, 'class' => 'btn btn-default btn-sm', 'title' => Yii::t('app', 'Create'), 'id' => 'btn-create']);
        }
    }

    public static function update($id) {
        if (Helper::checkRoute('update')) {
            return Html::a('<b>' . Yii::t('app', 'Update') . '</b>', ['update', 'id' => $id], ['class' => 'btn btn-default btn-sm ', 'title' => Yii::t('app', 'Update'), 'id' => 'btn-update']);
        }
    }

    public static function drop($id) {
        if (Helper::checkRoute('drop')) {
            echo Html::a('<span class="fa fa-trash"></span>', ['drop', 'id' => $id], [
                'class' => 'btn btn-danger btn-sm',
                'title' => Yii::t('app', 'Delete'),
                'data' => [
                    'confirm' => Yii::t('app', text::confirm_delete),
                    'method' => 'post',
                ],
            ]);
        }
    }

    public static function ajaxDrops() {
        if (Helper::checkRoute('ajax-drops')) {
            echo Html::a('<i class="fa fa-trash"></i> <b>' . Yii::t('app', 'Delete') . '</b>', '#', ['id' => 'btn-drops', 'class' => 'btn btn-danger btn-sm', 'title' => Yii::t('app', 'Delete')]);
        }
    }

    public static function delete($id) {
        if (Helper::checkRoute('delete')) {
            return Html::a('<i class=""></i> <b>' . Yii::t('app', 'Delete') . '</b>', ['delete', 'id' => $id], [
                        'class' => 'btn btn-danger btn-sm',
                        'title' => Yii::t('app', 'Delete'),
                        'data' => [
                            'confirm' => text::confirm_delete,
                            'method' => 'post',
                        ],
            ]);
        }
    }

    public static function deleteItems() {
        if (Helper::checkRoute('delete-items')) {
            echo Html::button('<span class="fa fa-trash"></span><b> ' . Yii::t('app', 'Delete') . '</b>', ['data-pjax' => 0, 'class' => 'btn btn-danger btn-sm', 'title' => Yii::t('app', 'Delete'), 'id' => 'btn-delete-items']);
        }
    }

    public static function viewFile($filename) {
        if (Helper::checkRoute('view-file')) {
            if (!empty($filename)) {
                return Html::a('<b>' . Yii::t('app', 'View File') . '</b>', ['view-file', 'filename' => $filename], [
                            'class' => 'btn btn-default btn-sm',
                            'title' => Yii::t('app', 'View File'),
                            'target' => '_blank'
                ]);
            } else {
                return '<b>' . Yii::t('app', 'No File') . ' </b>';
            }
        }
    }

    public static function pager() {
        return [
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
        ];
    }

    public static function actionColumnButtons() {
        return [
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
        ];
    }

}
