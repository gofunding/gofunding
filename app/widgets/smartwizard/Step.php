<?php
namespace app\widgets\smartwizard;

use yii\helpers\Html;

/**
 * \kuakling\smartwizard\Step.
 *
 * @author kuakling <kuakling@gmail.com>
 * @since 2.0
 */
class Step extends \yii\base\Widget
{
    public $toolbarExtraButtons = [];
    
    public $widgetOptions = [];
    
    public $items = [];
    
    public $isFormStep = false;
    
    /**
     * Renders the widget.
     */
    public function run()
    {
        $asset = SmartWizardAsset::register($this->getView());
        $this->registerWidget($asset);
        return $this->renderWidget($asset);
    }
    
    public function renderWidget($asset)
    {
        $render['nav'] = $this->renderNav();
        $render['content'] = $this->renderContent($asset);
        return Html::tag('div', implode("\n", $render), ['id' => $this->id, 'class' => 'sw-main sw-theme-'.$this->getTheme($asset)]);
    }
    
    public function renderNav()
    {
        return Html::ul($this->items, ['item' => function($item, $index) {
            return Html::tag('li', 
                $this->render('_nav-item-default', ['item' => $item, 'index' => $index, 'widget' => $this]),
                ['class' => 'post']
            );
        }, 'class' => 'nav nav-tabs step-anchor']);
    }
    
    public function renderContent($asset)
    {
        $contentArr = [];
        $formStepNum = 0;
        foreach ($this->items as $key => $item) {
            if($this->isFormStep) {
                $item['content'] = Html::tag('div', $item['content'], ['id' => "{$this->id}-form-step-{$formStepNum}"]);
                $formStepNum++;
            }
            $contentArr[] = Html::tag('div', $item['content'], ['id' => "{$this->id}-step-{$key}", 'class' => 'step-content', 'style' => 'display:none']);
        }
        
        return Html::tag('div',implode("\n", $contentArr), ['class' => 'sw-container tab-content']);
    }
    
    public function registerWidget($asset)
    {
        $view = $this->getView();
        $jsonOptions = \yii\helpers\Json::encode($this->widgetOptions);
        $js[] = <<< JS
$('#{$this->id}').smartWizard($jsonOptions);
JS;
        
        $view->registerJs(implode("\n", $js));
    }
    
    public function getTheme($asset)
    {
        $view = $this->getView();
        $theme = 'default';
        $cssFile = 'smart_wizard.css';
        if(isset($this->widgetOptions['theme'])){
            $requestTheme = $this->widgetOptions['theme'];
            switch ($requestTheme) {
                case 'arrows' : $cssFile = 'smart_wizard_theme_arrows.css'; $theme = $requestTheme;
                    break;
                case 'circles' : $cssFile = 'smart_wizard_theme_circles.css'; $theme = $requestTheme;
                    break;
                case 'dots' : $cssFile = 'smart_wizard_theme_dots.css'; $theme = $requestTheme;
                    break;
                default : $cssFile = 'smart_wizard.css'; $theme = 'default';
                    break;
            }
        }
        $view->registerCssFile($asset->baseUrl.'/css/'.$cssFile, ['depends' => ['\app\widgets\smartwizard\SmartWizardAsset']]);
        
        return $theme;
    }
}
