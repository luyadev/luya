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
    public $sourcePath = '@luya/lazyload/resources';
    
    /**
     * @var array An array with all javascript files for this asset located in the source path folder.
     */
    public $js = [
        'lazyload.min.js',
    ];
    
    /**
     * @var array An array with assets this asset depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
