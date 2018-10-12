<?php
use yii\helpers\Html;
?>

<?php
$label = '';
if(isset($item['icon'])) {
    $label = Html::tag('i', null, ['class' => $item['icon']]);
}
$label .= ' ' . $item['label'];
?>
<?= Html::a($label, "#{$widget->id}-step-" . $index); ?>
