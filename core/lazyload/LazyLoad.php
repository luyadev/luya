<?php

namespace luya\lazyload;

use luya\base\Widget;
use luya\web\View;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

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
 * @author Marc Stampfli <marc@zephir.ch>
 * @author Alex Schmid <schmid@netfant.ch>
 * @since 1.0.0
 */
class LazyLoad extends Widget
{
    public const JS_ASSET_KEY = 'lazyload.js.register';

    public const CSS_ASSET_KEY = 'lazyload.css.register';
    public const CSS_ASSET_KEY_PLACEHOLDER = 'lazyload.placeholder.css.register';

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
     * @var array Options array for the html tag. This array can be used to pass e.g. a `title` or `alt` tag.
     * @since 1.6.0
     */
    public $options = [];

    /**
     * @var boolean Legacy support for older Browsers (Adds the IntersectionOberserver Polyfill, default: true)
     * @since 1.6.0
     */
    public $legacySupport = true;

    /**
     * @var boolean Optionally disable the automatic init of the lazyload function so you can override the JS options
     * @since 1.6.0
     */
    public $initJs = true;

    /**
     * @var boolean If set to false, the size will be set by the placeholder (based on width/height). This enables
     * smoother fading of the image. Leave on true to have it work with CSS Frameworks like Bootstrap.
     * Has no effect if `attributesOnly` is `true`.
     * @since 1.6.1
     */
    public $replacePlaceholder = true;

    /**
     * @var string The default classes which will be registered.
     * @since 1.6.1
     */
    public $defaultCss = '
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
            -webkit-transition: .5s ease-in-out opacity;
            transition: .5s ease-in-out opacity;
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
        .lazyimage-placeholder {
            display: block;
            width: 100%;
            height: auto;
        }
        .nojs .lazyimage,
        .nojs .lazyimage-placeholder,
        .no-js .lazyimage,
        .no-js .lazyimage-placeholder {
            display: none;
        }
    ';

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
        if ($this->legacySupport) {
            IntersectionObserverPolyfillAsset::register($this->view);
            $this->view->registerJs("IntersectionObserver.prototype.POLL_INTERVAL = 100;", View::POS_READY);
        }
        LazyLoadAsset::register($this->view);

        if ($this->initJs) {
            // register js and css code with keys in order to ensure the registration is done only once
            $this->view->registerJs("
                $.lazyLoad();
            ", View::POS_READY, self::JS_ASSET_KEY);
        }

        $this->view->registerCss($this->defaultCss, [], self::CSS_ASSET_KEY);
    }

    /**
     * Returns the aspect ration based on height or width.
     *
     * If no width or height is provided, the default value 0 will be returned.
     *
     * @return float A dot seperated ratio value
     * @since 1.6.1
     */
    protected function generateAspectRation()
    {
        return ($this->height && $this->width) ? str_replace(',', '.', ($this->height / $this->width) * 100) : 56.25;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->placeholderSrc && $this->placeholderAsBase64) {
            $this->placeholderSrc = 'data:image/jpg;base64,' . base64_encode(file_get_contents($this->placeholderSrc));
        }

        if ($this->attributesOnly && !$this->placeholderSrc) {
            return "class=\"js-lazyimage $this->extraClass\" data-src=\"$this->src\" data-width=\"$this->width\" data-height=\"$this->height\" data-as-background=\"1\"";
        }

        $tag = '<div class="lazyimage-wrapper ' . $this->extraClass . '">';
        $tag .= Html::tag('img', '', array_merge(
            $this->options,
            [
                'class' => 'js-lazyimage lazyimage' . ($this->replacePlaceholder ? (' ' . $this->extraClass) : ''),
                'data-src' => $this->src,
                'data-width' => $this->width,
                'data-height' => $this->height,
                'data-replace-placeholder' => $this->replacePlaceholder ? '1' : '0'
            ]
        ));
        if ($this->placeholderSrc) {
            $tag .= Html::tag('img', '', ['class' => 'lazyimage-placeholder', 'src' => $this->placeholderSrc]);
        } else {
            $tag .= '<div class="lazyimage-placeholder"><div style="display: block; height: 0px; padding-bottom: ' . $this->generateAspectRation() . '%;"></div><div class="loader"></div></div>';
        }
        $tag .= '<noscript><img class="loaded ' . $this->extraClass . '" src="'.$this->src.'" /></noscript>';
        $tag .= '</div>';

        return $tag;
    }
}
