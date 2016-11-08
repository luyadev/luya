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
    /**
     * @var string The path to the folder where the files of this asset are located.
     */
    public $sourcePath = '@admin/resources/flow';
    
    /**
     * @var array A list of javascript files located in the $sourcePath folder.
     */
    public $js = [
        'ng-flow-standalone.min.js',
    ];
    
    /**
     * @var array A list of asset files on where this asset file depends on, it means the current files will be included after the depending files.
     */
    public $depends = [
        'luya\admin\assets\Main',
    ];
}
