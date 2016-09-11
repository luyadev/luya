<?php

namespace luya\lazyload;

use luya\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use luya\web\View;

/**
 * Generate images with LazyLoad Tags
 * 
 * ```php
 * <?= LazyLoad::widget(['src' => 'http://www.zephir.ch/img/zephir-logo.png']); ?>
 * ```
 * 
 * @author Basil Suter <basil@nadar.io>
 * @author Marc Stampfli <marc.stampfli@zephir.ch>
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
     * @var string Additional classes for the lazy load image.
     */
    public $class = null;
    
    /**
     * {@inheritDoc}
     * @see \yii\base\Object::init()
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
        }
    }
    
    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        $html = Html::tag('img', '', ['class' => 'lazy-image ' . $this->class, 'data-src' => $this->src, 'data-width' => $this->width, 'data-height' => $this->height]);
        $html.= '<noscript><img class="lazy-image '.$this->class.'" src="'.$this->src.'" /></noscript>';
        return $html;
    }
}