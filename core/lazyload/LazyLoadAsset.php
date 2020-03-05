<?php

namespace luya\lazyload;

use luya\web\Asset;

/**
 * The Lazyload asset files provides all required resources and implements jquery.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class LazyLoadAsset extends Asset
{
    /**
     * @var string The path to the source files of the asset.
     */
    public $sourcePath = '@luya/resources/lazyload';

    /**
     * @var array An array with all javascript files for this asset located in the source path folder.
     */
    public $js = [
        YII_ENV_PROD ? 'lazyload.js' : 'lazyload.src.js',
    ];

    /**
     * @var array An array with assets this asset depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}