<?php

use yii\helpers\Html;
use app\widgets\wizardwidget\WizardWidget;
use yii\bootstrap\ActiveForm;
// use app\models\CampaignKategori;
// use app\models\Campaign;
// use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */

$this->title = Yii::t('app', 'Create Campaign');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaigns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-create row">
	<div class="col-md-8 col-md-offset-2">
		<!-- <div class="panel">
			<div class="panel-body">
				<ul class="nav nav-pills nav-justified">
					<li role="presentation" class="active"><a href="#">INFORMASI CAMPAIGN</a></li>
				  	<li role="presentation"><a href="#">CREATE CAMPAIGN</a></li>
				</ul>
			</div>
		</div> -->
	    <?php // $this->render('_form', [
	    //     'model' => $model,
	    // ]) ?>

		<?php 
		$form = ActiveForm::begin([
	        'options' => [
	        	'class' => 'form-horizontal', 
	        	'id' => 'campaign-create-form',
	        	'enctype' => 'multipart/form-data'
	        	// 'data-pjax' => true
	        ],
	        'layout' => 'horizontal',
	        'fieldConfig' => [
	            'template' => "<div class=\"col-md-4\">{label}</div>\n<div class=\"col-md-8\">{input}{error}</div><div class=\"col-md-3\"></div>\n",
	            'labelOptions' => ['class' => 'text-left1'],
	        ],
	            //'enableAjaxValidation' => true,
	            //'validateOnBlur' => true
	    ]); ?>

		<div id="wizard">
			<?php
				echo $this->render('_form-step-1', ['model' => $model, 'form' => $form]);
				echo $this->render('_form-step-2', ['model' => $model, 'form' => $form]);
				echo $this->render('_form-step-3', ['modelProfile' => $modelProfile, 'form' => $form]);
			?>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>