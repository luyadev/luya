<?php

namespace luya\admin\assets;

/**
 * Login Asset contains all required files for the administration login screen.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Login extends \luya\web\Asset
{
    /**
     * @var string The path to the folder where the files of this asset are located.
     */
    public $sourcePath = '@admin/resources';

    /**
     * @var array A list of css style documents located in the $sourcePath folder.
     */
    public $css = [
        'dist/css/admin.css',
        'css/login.css',
    ];

    /**
     * @var array A list of javascript files located in the $sourcePath folder.
     */
    public $js = [
        'dist/js/login.js',
    ];

    /**
     * @var array A list of asset files on where this asset file depends on, it means the current files will be included after the depending files.
     */
    public $depends = [
        'luya\admin\assets\Jquery',
    ];
}
