<?php

namespace luya\lazyload;

use luya\web\Asset;

/**
 * The Lazyload asset files provides all required resources and implements jquery.
 *
 * @author Marc Stampfli <marc@zephir.ch>
 * @since 1.6.0
 */
class IntersectionObserverPolyfillAsset extends Asset
{
    /**
     * @var string The path to the source files of the asset.
     */
    public $sourcePath = '@luya/resources/lazyload';

    /**
     * @var array An array with all javascript files for this asset located in the source path folder.
     */
    public $js = [
        YII_DEBUG ? 'intersectionObserver.polyfill.src.js' : 'intersectionOberserver.polyfill.js',
    ];

    /**
     * @var array An array with assets this asset depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
