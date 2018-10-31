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
    const CSS_ASSET_KEY_PLACEHOLDER = 'lazyload.placeholder.css.register';

    /**
     * @var string The path to the image you want to lazy load.
     */
    public $src;

    /**
     * @var string Path for the placeholder image that will be base64 encoded.
     * @since 1.0.14
     */
    public $placeholderSrc;

    /**
     * @var boolean Inline the placeholder source as base64 encoded string
     * @since 1.0.14
     */
    public $placeholderAsBase64 = false;

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

        if ($this->placeholderSrc) {
            $this->view->registerCss("
                .lazyimage-wrapper {
                    display: block;
                    width: 100%;
                    position: relative;
                    overflow: hidden;
                }
                .lazyimage {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    bottom: 0;
                    right: 0;
                    opacity: 0;
                    height: 100%;
                    width: 100%;
                    -webkit-transition: 1s ease-in-out opacity;
                    transition: 1s ease-in-out opacity;
                    -webkit-transform: translate(-50%,-50%);
                    transform: translate(-50%,-50%);
                    -o-object-fit: cover;
                    object-fit: cover;
                    -o-object-position: center center;
                    object-position: center center;
                    z-index: 20;
                }
                .lazyimage.loaded {
                    opacity: 1;
                }
                .lazyimage-placeholder-image {
                    display: block;
                    width: 100%;
                    height: auto;
                }
                .nojs .lazyimage,
                .nojs .lazyimage-placeholder-image,
                .no-js .lazyimage,
                .no-js .lazyimage-placeholder-image {
                    display: none;
                }
            ", [], self::CSS_ASSET_KEY_PLACEHOLDER);
        } else {
            $this->view->registerCss("
                .lazy-image {
                    display: none;
                }
                .lazy-image.loaded {
                    display: block;
                }
                .lazy-placeholder {
                    background-color: #f2f2f2;
                    position: relative;
                    display: block;
                }
            ", [], self::CSS_ASSET_KEY);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $class = ($this->placeholderSrc ? 'lazyimage-wrapper' : 'lazy-image') . ' ' . $this->extraClass;

        if ($this->placeholderSrc && $this->placeholderAsBase64) {
            $this->placeholderSrc = 'data:image/jpg;base64,' . base64_encode(file_get_contents($this->placeholderSrc));
        }

        if ($this->attributesOnly && !$this->placeholderSrc) {
            return "class=\"{$class}\" data-src=\"$this->src\" data-width=\"$this->width\" data-height=\"$this->height\" data-as-background=\"1\"";
        }

        if ($this->placeholderSrc) {
            $tag = '<div class="' . $class . '">';
            $tag .= Html::tag('img', '', ['class' => 'lazy-image lazyimage', 'data-src' => $this->src]);
            $tag .= Html::tag('img', '', ['class' => 'lazyimage-placeholder-image', 'src' => $this->placeholderSrc]);
            $tag .= '<noscript><img class="lazyimage-image" src="' . $this->src . '" /></noscript>';
            $tag .= '</div>';
        } else {
            $tag = Html::tag('img', '', ['class' => $class, 'data-src' => $this->src, 'data-width' => $this->width, 'data-height' => $this->height]);
            $tag .= '<noscript><img class="'.$class.'" src="'.$this->src.'" /></noscript>';
        }

        return $tag;
    }
}
