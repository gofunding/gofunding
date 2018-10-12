# yii2-smart-wizard

## Basic
~~~ php
<?php
use kuakling\smartwizard\Step;

echo Step::widget([
    'widgetOptions' => [
        'theme' => 'default',
        'showStepURLhash' => false,
        'autoAdjustHeight' => false,
    ],
    'items' => [
        1 => [
            'icon' => 'fa fa-user,
            'label' => 'Step - 1',
            'content' => 'Content 1'
        ],
        2 => [
            'icon' => 'fa fa-check',
            'label' => 'Step - 2',
            'content' => '<h2>Content 2 </h2>'
        ],
    ],
]);
~~~

## Form Validate
~~~ php
<?php $form = ActiveForm::begin([
    'options' => [
        'role'=>"form",
        'data-toggle'=>"validator",
        'accept-charset'=>"utf-8",
        'novalidate'=>"true"
    ]
]); 

$wizardId = 'person-wizard';

$jsPersonWizard['btn'] = <<< JS
// Toolbar extra buttons
var btnFinish = $('<button></button>').html('<i class="fa fa-flag-checkered"></i> Finish')
    .addClass('btn btn-primary')
    .on('click', function(){
        $.each($('.step-content'), function(){
            if($(this).find('.has-error').length) {
                $('a[href="#'+$(this).prop('id')+'"]').addClass('error');
            }
        });
    });
    
var btnCancel = $('<button></button>').html('<i class="fa fa-times"></i> Cancel')
    .addClass('btn btn-default')
    .on('click', function(){ $('#{$wizardId}').smartWizard('reset'); });
JS;

$jsPersonWizard['event'] = <<< JS
$('#{$wizardId}').on('showStep', function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
    //alert('You are on step '+stepNumber+' now');
    $('#{$form->id}').yiiActiveForm("resetForm");
    if(stepPosition === 'first'){
        $('#prev-btn').addClass('disabled');
    }else if(stepPosition === 'final'){
        $('#next-btn').addClass('disabled');
    }else{
        $('#prev-btn').removeClass('disabled');
        $('#next-btn').removeClass('disabled');
    }
});

$('#{$wizardId}').on('leaveStep', function(e, anchorObject, stepNumber, stepDirection) {
    var elmForm = $('#{$wizardId}-form-step-' + stepNumber);
    if(stepDirection === 'forward' && elmForm){
        var inputs = elmForm.find('*[id]:visible');
        data = $('#{$form->id}').data("yiiActiveForm");
        $.each(data.attributes, function(i, item) {
            this.status = 3;
        });
        $('#{$form->id}').yiiActiveForm("validate");
        if (elmForm.find(".has-error").length) {
            return false;
        }

    }
    return true;

});
JS;

$this->registerJs(implode("\n", $jsPersonWizard));


echo Step::widget([
    'id' => $wizardId,
    'isFormStep' => true,
    'widgetOptions' => [
        'theme' => 'default',
        'showStepURLhash' => false,
        'autoAdjustHeight' => false,
        'toolbarSettings' => [
            'toolbarPosition' => 'both',
            'toolbarExtraButtons' => new JsExpression("[btnFinish, btnCancel]"),
        ],
    ],
    'items' => [
        1 => [
            'icon' => 'fa fa-info',
            'label' => 'Step - 1 <br /><small>Information</small>',
            'content' => $this->render('_step-1', ['models' => $models, 'form' => $form])
        ],
        2 => [
            'icon' => 'fa fa-camera',
            'label' => 'Step - 2 <br /><small>Photo</small>',
            'content' => $this->render('_step-2', ['models' => $models, 'form' => $form])
        ],
        3 => [
            'icon' => 'fa fa-address-card',
            'label' => 'Step - 3 <br /><small>Address</small>',
            'content' => $this->render('_step-3', ['models' => $models, 'form' => $form])
        ],
    ],
]);
?>

<?php ActiveForm::end(); ?>
~~~
