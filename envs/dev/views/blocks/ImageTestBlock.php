<?php use luya\lazyload\LazyLoad;

?>
<?= LazyLoad::widget([
    'src' => $extras['image']->source,
    'width' => $extras['image']->resolutionWidth,
    'height' => $extras['image']->resolutionHeight,
]) ?>