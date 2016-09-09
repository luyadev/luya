<?php

namespace luya\lazyload;

use luya\web\Asset;

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