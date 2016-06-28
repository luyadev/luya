<?php

namespace admin\assets;

/**
 * Main Asset contains all administration area depending files and should be a dependency for all other assets.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Main extends \luya\web\Asset
{
    public $sourcePath = '@admin/resources';

    public $css = [
        'css/admin.css',
    ];

    public $js = [
        //'js/libs/ResizeSensor.js',
        //'js/libs/ElementQueries.js',
        'js/zaa.js',
        'js/services.js',
        'js/directives.js',
        'js/controllers.js',
    ];

    public $depends = [
        'admin\assets\Jquery',
        'admin\assets\BowerVendor',
    ];
    
    /*
    public $publishOptions = [
        'only' => [
            'js/*',
            'css/*',
            'fonts/*',
        ]
    ];
    */
}
