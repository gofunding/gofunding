<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Campaign */

$this->title = Yii::t('app', 'Create Campaign');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaigns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-create row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel">
			<div class="panel-body">
				<ul class="nav nav-pills nav-justified">
					<li role="presentation"><a href="#">INFORMASI CAMPAIGN</a></li>
				  	<li role="presentation" class="active"><a href="#">CREATE CAMPAIGN</a></li>
				</ul>
			</div>
		</div>
	    <?= $this->render('_form-step-2', [
	        'model' => $model,
	    ]) ?>
	</div>
</div>