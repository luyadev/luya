<?php

namespace luya\admin\assets;

use luya\web\Asset;

/**
 * Asset files for the Flow Uploader
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Flow extends Asset
{
    public $sourcePath = '@admin/resources/flow';
    
    public $js = [
        'ng-flow-standalone.min.js',
    ];
    
    public $depends = [
        'luya\admin\assets\Main',
    ];
}
