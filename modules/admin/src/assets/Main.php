<?php

namespace luya\admin\assets;

/**
 * Main Asset contains all administration area depending files and should be a dependency for all other assets.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Main extends \luya\web\Asset
{
    /**
     * @var string The path to the folder where the files of this asset are located.
     */
    public $sourcePath = '@admin/resources';

    /**
     * @var array A list of css style documents located in the $sourcePath folder.
     */
    public $css = [
        'dist/css/admin.css'
    ];

    /**
     * @var array A list of javascript files located in the $sourcePath folder.
     */
    public $js = [
        'dist/js/main.min.js',
    ];

    /**
     * @var array A list of asset files on where this asset file depends on, it means the current files will be included after the depending files.
     */
    public $depends = [
        'luya\admin\assets\Jquery',
    ];
}
