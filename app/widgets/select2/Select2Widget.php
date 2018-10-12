<?php

namespace app\widgets\select2;

use yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\helpers\Json;

class Select2Widget extends \yii\widgets\InputWidget
{
 
    public $bootstrap = true;
    public $language;
    public $data;
    public $ajax;
    public $items = [];
    public $placeholder = "--- Pilih ---";
    public $multiple;
    public $tags;
    public $clientOptions = [];
    public $columnId = 'id';
    public $columnText = 'name';
    public function init()
    {
        parent::init();
        
        if ($this->tags) {
            $this->options['data-tags'] = 'true';
            $this->options['multiple'] = true;
        }
        if ($this->language) {
            $this->options['data-language'] = $this->language;
        }
        if (!is_null($this->ajax)) {
       
            $this->clientOptions['ajax']['url']=Url::to($this->ajax);
            $this->clientOptions['ajax']['dataType'] = 'json';
            $this->clientOptions['ajax']['delay'] = 200;
            $this->clientOptions['ajax']['cache'] = false;
            $this->clientOptions['ajax']['method'] = 'GET';
            $this->clientOptions['ajax']['data'] = new JsExpression(
                    'function (params) {
                      return {
                        q: params.term, // search term
                        page: params.page
                        //page: 20
                      };
                    }'
                );
            $this->clientOptions['ajax']['processResults'] =
            new JsExpression( 
            'function (data, params) {
                params.page = params.page || 1;
                return {            
                    pagination: {
                        more: (params.page * 25) < data.total_count
                    },
                    results: $.map(data.items, function(obj) {
                        return { id: obj.'.$this->columnId.', text: obj.'.$this->columnText.' };
                    }),
                };
            }'
            );
        }
        
        $this->options['data-placeholder'] = $this->placeholder;
      
        if ($this->multiple) {
            $this->options['data-multiple'] = 'true';
            $this->options['multiple'] = true;
        }
        if (!empty($this->data)) {
            $this->options['data-data'] = \yii\helpers\Json::encode($this->data);
        }
        if (!isset($this->options['class'])) {
            $this->options['class'] = 'form-control';
        }
        if ($this->bootstrap) {
            $this->options['data-theme'] = 'bootstrap';
        }
        if ($this->multiple || !empty($this->clientOptions['multiple'])) {
            if ($this->hasModel()) {
                $name = isset($this->options['name']) ? $this->options['name'] : Html::getInputName($this->model, $this->attribute);
            } else {
                $name = $this->name;
            }
            if (substr($name, -2) != '[]') {
                $this->options['name'] = $this->name = $name . '[]';
            }
        }
    }

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        } else {
            echo Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }
        $this->registerAssets();
    }
    
    /**
     * Registers Assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $bandle = Select2Asset::register($view);
        if ($this->language !== false) {
            $langs[0] = $this->language ? $this->language : \Yii::$app->language;
            if (($pos = strpos($langs[0], '-')) > 0) {
                $langs[1] = substr($langs[0], 0, $pos);
            }
            foreach ($langs as $lang) {
                $langFile = "/js/i18n/{$lang}.js";
                if (file_exists($bandle->sourcePath . $langFile)) {
                    $view->registerJsFile($bandle->baseUrl . $langFile, ['depends' => Select2Asset::className()]);
                    break;
                }
            }
        }
        if ($this->bootstrap) {
            Select2BootstrapAsset::register($view);
        }
        $clientOptions = Json::encode($this->clientOptions);
   
        $view->registerJs("jQuery('#{$this->options['id']}').select2($clientOptions);");
    }
}
