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
 * In order to read more visit the [[concept-lazyload.md]] guide section.
 *
 * @author Basil Suter <basil@nadar.io>
 * @author Marc Stampfli <marc.stampfli@zephir.ch>
 * @since 1.0.0
 */
class LazyLoad extends Widget
{
    const JS_ASSET_KEY = 'lazyload.js.register';

    const CSS_ASSET_KEY = 'lazyload.css.register';

    /**
     * @var string The path to the image you want to lazy load.
     */
    public $src;

    /**
     * @var integer The width of the image, this information should be provided in order to display a placeholder.
     */
    public $width;

    /**
     * @var integer The height of the image, this information should be provided in order to display a placeholder.
     */
    public $height;

    /**
     * @var boolean Define whether a full image tag should be return or only the attributes. This can be applied when using the lazy loader in background images.
     */
    public $attributesOnly = false;

    /**
     * @var string Additional classes for the lazy load image.
     */
    public $extraClass;

    public $base64Src = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->src === null) {
            throw new InvalidConfigException("The parameter src is required by the lazyload widget.");
        }

        // register the asset file
        LazyLoadAsset::register($this->view);

        // register js and css code with keys in order to ensure the registration is done only once
        $this->view->registerJs("$('.lazy-image').lazyLoad();", View::POS_READY, self::JS_ASSET_KEY);

        if ($this->base64Src) {
            $this->view->registerCss("
                .lazy-image-wrapper {
                    display: block;
                    width: 100%;
                    position: relative;
                    overflow: hidden;
                }
                .lazy-image {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    bottom: 0;
                    right: 0;
                    opacity: 0;
                    height: 100%;
                    width: auto;
                    -webkit-transition: 1s ease-in-out opacity;
                    transition: 1s ease-in-out opacity;
                    -webkit-transform: translate(-50%,-50%);
                    transform: translate(-50%,-50%);
                    -o-object-fit: cover;
                    object-fit: cover;
                    -o-object-position: center center;
                    object-position: center center;
                }
                .lazy-image-placeholder {
                    display: block;
                    width: 100%;
                    heoght: auto;
                }
                .nojs .lazy-image,
                .nojs .lazy-image-placeholder,
                .no-js .lazy-image,
                .no-js .lazy-image-placeholder {
                    display: none;
                }
            ", [], self::CSS_ASSET_KEY);
        } else {
            $this->view->registerCss(".lazy-image { display: none; }", [], self::CSS_ASSET_KEY);
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

        $tag = '';
        $tag .= $this->base64Src ? '<div class="lazy-image-wrapper">' : '';
        $tag .= $this->base64Src ? Html::tag('img', '', ['class' => 'lazy-image-placeholder', 'src' => $this->base64Src]) : '';
        $tag .= Html::tag('img', '', ['class' => $class, 'data-src' => $this->src, 'data-width' => $this->width, 'data-height' => $this->height]);
        $tag .= '<noscript><img class="'.$class.'" src="'.$this->src.'" /></noscript>';
        $tag .= $this->base64Src ? '</div>' : '';

        return $tag;
    }
}
