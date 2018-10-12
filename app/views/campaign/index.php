<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Campaigns');
$this->params['breadcrumbs'][] = $this->title;
$formatter = Yii::$app->formatter;
?>

<div class="campaign-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <hr>
	<div class="container text-center">
		<div class="row">
			<?php 
				echo ListView::widget([
					'dataProvider' => $model,
					'itemOptions' => ['class' => 'item'],
					'itemView' => '_item',
					'pager' => [
						'class' => ScrollPager::className(),
						'triggerTemplate' => '<div class="ias-trigger" style="text-align: center; cursor: pointer;"><a class="btn btn-primary">{text}</a></div>',
						// 'container' => '.list-view',
						// 'item' => 'item',
						// 'paginationSelector' => '.list-view .pagination',
						// 'next' => '.next a',
						// 'negativeMargin' => 1100,
						'enabledExtensions' => [
							ScrollPager::EXTENSION_TRIGGER, 
							//   ScrollPager::EXTENSION_SPINNER, 
							// ScrollPager::EXTENSION_NONE_LEFT, 
							// ScrollPager::EXTENSION_PAGING, 
						//   	ScrollPager::EXTENSION_HISTORY,
						],
						// 'delay' => 600,
						// 'triggerOffset'=> 2,
						// 'overflowContainer' => '.row',
					],
				]);
			?>
		</div>
    </div>
    <p>
        <?php // Html::a(Yii::t('app', 'Create Campaign'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>