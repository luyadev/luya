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
    public $src = null;
    
    public $width = null;
    
    public $height = null;
    
    public $class = 'lazy-image image';
    
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
    
    public function run()
    {
        $tag = Html::tag('img', '', ['class' => $this->class, 'data-src' => $this->src, 'data-width' => $this->width, 'data-height' => $this->height]);
        $tag.= '<noscript><img class="'.$this->class.'" src="'.$this->src.'" /></noscript>';
        return $tag;
    }
}