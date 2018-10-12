<?php

namespace app\widgets\toastr;

use yii\helpers\Json;

/**
 * Description of Toastr
 *
 * @author Odai Alali <odai.alali@gmail.com>
 */
class Toastr extends \yii\base\Widget {

    const TYPE_ERROR = 'danger';
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';

    public $customStyle = true;
    public $toastType;
    public $title;
    public $message;
    public $options = [];
    protected $jsonOptions = [];

    public function init() {
        parent::init();
        if (empty($this->toastType)) {
            $this->toastType = self::TYPE_INFO;
        }
        if (empty($this->title)) {
            $this->title = false;
        }
        if ($this->customStyle) {
            ToastrCustomAsset::register($this->getView());
        } else {
            ToastrAsset::register($this->getView());
        }
    }

    public function run() {
        parent::run();
        $this->registerNotification();
    }

    protected function initJsOptions() {
        //if(isset)
        $value_arr = array();
        $replace_keys = array();
        if (isset($this->options['onclick']) && $this->options['onclick'] != null) {
            $value_arr[] = $this->options['onclick'];
            $this->options['onclick'] = '%onclick%';
            $replace_keys[] = '"%onclick%"';
        }
        if (isset($this->options['onShown']) && $this->options['onShown'] != null) {
            $value_arr[] = $this->options['onShown'];
            $this->options['onShown'] = '%onShown%';
            $replace_keys[] = '"%onShown%"';
        }
        if (isset($this->options['onHidden']) && $this->options['onHidden'] != null) {
            $value_arr[] = $this->options['onHidden'];
            $this->options['onHidden'] = '%onHidden%';
            $replace_keys[] = '"%onHidden%"';
        }
        $this->jsonOptions = empty($this->options) ? '[]' : Json::encode($this->options);
        $this->jsonOptions = str_replace($replace_keys, $value_arr, $this->jsonOptions);
    }

    protected function registerNotification() {
        $view = $this->getView();
        if ($this->options !== false) {
            $this->initJsOptions();
            switch ($this->toastType) {
                case 'error':
                    $js = "toastr.error('" . $this->message . "', '" . $this->title . "', " . $this->jsonOptions . ")";
                    break;
                case 'warning':
                    $js = "toastr.warning('" . $this->message . "', '" . $this->title . "', " . $this->jsonOptions . ")";
                    break;
                case 'info':
                    $js = "toastr.info('" . $this->message . "', '" . $this->title . "', " . $this->jsonOptions . ")";
                    break;
                case 'success':
                    $js = "toastr.success('" . $this->message . "', '" . $this->title . "', " . $this->jsonOptions . ")";
                    break;
            }
            if (isset($js)) {
                $view->registerJs($js);
            }
        }
    }

}
