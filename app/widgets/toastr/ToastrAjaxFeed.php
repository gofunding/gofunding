<?php

namespace app\widgets\toastr;

use dzas\widgets\ToastrAjaxFeedAsset;
use yii\helpers\Json;

class ToastrAjaxFeed extends \yii\base\Widget {

    public $customStyle = true;
    public $options = [];
    public $feedUrl = '';
    public $interval = 6000;

    public function init() {
        parent::init();
        if ($this->customStyle) {
            ToastrCustomAsset::register($this->getView());
        } else {
            ToastrAsset::register($this->getView());
        }
    }

    public function run() {
        parent::run();
        $view = $this->getView();
        $options = empty($this->options) ? '[]' : Json::encode($this->options);
        ToastrAjaxFeedAsset::register($view);
        $view->registerJs('jQuery(document).ready( function() {'
                . 'setInterval('
                . 'function(){'
                . 'ToastrAjaxFeed.getNotifications(\'' . $this->feedUrl . '\', ' . $options . ')'
                . '}'
                . ','
                . $this->interval . ');} );');
    }

}
