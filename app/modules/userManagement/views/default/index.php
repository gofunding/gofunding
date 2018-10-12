<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\userManagement\components\EnumColumn;
use app\widgets\admin\components\Helper;
use app\components\Buttons;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\administrator\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Management');
$this->params['breadcrumbs'][] = $this->title;
$data = Yii::$app->db->createCommand('SELECT name FROM auth_item WHERE type=1')->queryAll();
$rolesItem = ArrayHelper::map($data, 'name', 'name');
?>

<div class="box">
 <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box-body">
        <p>
        <div class="pull-right">
            <?= \app\widgets\PageSize::widget(['id' => 'select_page']); ?>
        </div>
        <?= Buttons::create() ?>
        </p>
        <?php Pjax::begin(); ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterSelector' => 'select[name="per-page"]',
            'pager' => Buttons::pager(),
            'layout' => '{summary}{items}<div class="text-center">{pager}</div>',
            'responsive' => true,
            'responsiveWrap' => false,
            'hover' => true,
            'bordered' => false,
            'striped' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',                
                [
                    'attribute' => 'username',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->username, ['view', 'id' => $data->id]);
                    }
                ],
                //'auth_key',
                //'password_hash',
                //'password_reset_token',
                'email:email',
                [
                    'attribute' => 'roles',
                    'format' => 'raw',
                    'class' => EnumColumn::className(),
                    'enum' => $rolesItem,
                    'filter' => $rolesItem,
                    'value' => function ($data) {
                        $roles = [];
                        foreach ($data->roles as $role) {
                            $roles[] = $role->item_name;
                        }
                        return implode(', ', $roles);
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'class' => EnumColumn::className(),
                    'enum' => Yii::$app->globalFunction->getStatusUser(),
                    'options' => ['width' => '80px'],
                    'value' => function ($data) {
                        return Yii::$app->globalFunction->getStatusUser($data['status']);
                    }
                ],
                [
                    'contentOptions' => ['style' => 'width:15%'],
                    'attribute' => 'created_at',
                    'value' => function($data) {
                        return Yii::$app->formatter->asDate($data['created_at']);
                    },
                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => [
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'autoWidget' => true,
                            'autoclose' => true,
                            'todayHighlight' => true
                        ]
                    ],
                ],
                [
                    'contentOptions' => ['style' => 'width:15%'],
                    'attribute' => 'updated_at',
                    'value' => function($data) {
                        return Yii::$app->formatter->asDate($data['updated_at']);
                    },
                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => [
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'autoWidget' => true,
                            'autoclose' => true,
                            'todayHighlight' => true
                        ]
                    ],
                ],
                [
                    'header' => 'Pilihan',
                    'contentOptions' => ['class' => 'text-center'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => Helper::filterActionColumn('{view} {update} {delete} {open-banned}'),
                    'buttons' => [
                        'view' => function ($url, $model) {
                            $icon = '<span class="btn btn-xs btn-default"><i class="fa fa-search-plus"></i></span>';
                            $url = ['view', 'id' => $model['id']];

                            return Html::a($icon, $url, [
                                        'title' => Yii::t('app', 'View'),
                                        'url' => $url,
//                                        'id' => 'modal-btn-view',
                                        'data-pjax' => 0,
                            ]);
                        },
                        'update' => function ($url, $model) {
                            $icon = '<span class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></span>';
                            $url = ['update', 'id' => $model['id']];

                            return Html::a($icon, $url, [
                                        'title' => Yii::t('app', 'Update'),
                                        'url' => $url,
//                                    'id' => 'modal-btn-view',
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
                                            'confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                                            'method' => 'post',
                                        ],
                                        'data-pjax' => false,
                            ]);
                        },
                        'open-banned' => function($url, $model) {
                            if ($model['status'] == 5) {
                                $icon = '<span class="btn btn-xs btn-warning">Membuka Bokir</span> ';
                                $url = ['open-banned', 'id' => $model['id']];

                                return Html::a($icon, $url, [
                                            'url' => $url,
                                            'title' => Yii::t('app', 'Membuka Blokir'),
                                            'data' => [
                                                'confirm' => Yii::t('app', 'Anda yakin akan membuka blokir akun ini?'),
                                                'method' => 'post',
                                            ],
                                            'data-pjax' => false,
                                ]);
                            }
                        }
                    ],
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>