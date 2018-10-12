<?php

namespace app\widgets;

use yii\helpers\Html;
use Yii;

/**
 * <?php echo \app\widgets\PageSize::widget(); ?>
 * ~~~
 *
 * and set the `filterSelector` property of GridView as shown in
 * following example.
 *
 * ~~~
 * <?= GridView::widget([
 *      'dataProvider' => $dataProvider,
 *      'filterModel' => $searchModel,
 * 		'filterSelector' => 'select[name="per-page"]',
 *      'columns' => [
 *          ...
 *      ],
 *  ]); ?>
 * ~~~
 */
class PageSize extends \yii\base\Widget {

    const count = 20;

    /**
     * @var string the label text.
     */
    public $label; // = Yii::t('app', 'Show data');
    public $label2;

    /**
     * @var integer the defualt page size. This page size will be used when the $_GET['per-page'] is empty.
     */
    public $defaultPageSize = 10;

    /**
     * @var string the name of the GET request parameter used to specify the size of the page.
     * This will be used as the input name of the dropdown list with page size options.
     */
    public $pageSizeParam = 'per-page';

    /**
     * @var array the list of page sizes
     */
    public $sizes = [2 => 2, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 50 => 50];

    /**
     * @var string the template to be used for rendering the output.
     */
    public $template = '{label} {list} {label2}';

    /**
     * @var array the list of options for the drop down list.
     */
    public $options;

    /**
     * @var array the list of options for the label
     */
    public $labelOptions;

    /**
     * @var boolean whether to encode the label text.
     */
    public $encodeLabel = true;

    /**
     * Runs the widget and render the output
     */
    public function run() {

        if (empty($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        if ($this->encodeLabel) {
            $this->label = \Yii::t('app', 'Show');
            $this->label = Html::encode($this->label);
            $this->label2 = \Yii::t('app', 'Data');
            $this->label2 = Html::encode($this->label2);
        }

        $perPage = !empty($_GET[$this->pageSizeParam]) ? $_GET[$this->pageSizeParam] : $this->defaultPageSize;
        $listHtml = Html::dropDownList('per-page', $perPage, $this->sizes, $this->options);
        $labelHtml = Html::label($this->label, $this->options['id'], $this->labelOptions);
        $label2Html = Html::label($this->label2, $this->options['id'], $this->labelOptions);
//        $output = str_replace(['{list}', '{label}'], [$listHtml, $labelHtml], $this->template);
        $output = str_replace(['{list}', '{label}', '{label2}'], [$listHtml, $labelHtml, $label2Html], $this->template);

        return $output;
    }

}
