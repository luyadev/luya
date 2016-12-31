<?php

namespace luya\lazyload;

use luya\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use luya\web\View;

/**
 * Image Lazy Loader.
 *
 * ```php
 * <?= LazyLoad::widget(['src' => 'http://www.zephir.ch/img/zephir-logo.png']); ?>
 * ```
 *
 * In order to read more visit the [[concept-lazyload.md]] Guide section.
 *
 * @author Basil Suter <basil@nadar.io>
 * @author Marc Stampfli <marc.stampfli@zephir.ch>
 * @since 1.0.0
 */
class LazyLoad extends Widget
{
    /**
     * @var string The path to the image you want to lazy load.
     */
    public $src = null;
    
    /**
     * @var integer The width of the image, this information should be provided in order to display a placeholder.
     */
    public $width = null;
    
    /**
     * @var integer The height of the image, this information should be provided in order to display a placeholder.
     */
    public $height = null;

    /**
     * @var boolean Define whether a full image tag should be return or only the attributes. This can be applied when using the lazy loader in background images.
     */
    public $attributesOnly = false;

    /**
     * @var string Additional classes for the lazy load image.
     */
    public $extraClass = null;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if ($this->src === null) {
            throw new InvalidConfigException("The parameter src is required by the lazyload widget.");
        }
        
        static::$counter++;
        
        if (static::$counter == 1) {
            LazyLoadAsset::register($this->view);
            $this->view->registerJs("$('.lazy-image').lazyLoad();", View::POS_READY);
            $this->view->registerCss(".lazy-image { display: none; }");
        }
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $class = 'lazy-image ' . $this->extraClass;
        
        if ($this->attributesOnly) {
            return "class=\"{$class}\" data-src=\"$this->src\" data-width=\"$this->width\" data-height=\"$this->height\" data-as-background=\"1\"";
        }
        
        $tag = Html::tag('img', '', ['class' => $class, 'data-src' => $this->src, 'data-width' => $this->width, 'data-height' => $this->height]);
        $tag.= '<noscript><img class="'.$class.'" src="'.$this->src.'" /></noscript>';
        return $tag;
    }
}
