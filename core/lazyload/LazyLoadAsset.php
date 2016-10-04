<?php

namespace luya\lazyload;

use luya\web\Asset;

/**
 * The Lazyload asset files provides all required resources and implements jquery.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class LazyLoadAsset extends Asset
{
    public $sourcePath = '@luya/lazyload/resources';
    
    public $js = [
        'lazyload.min.js',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
