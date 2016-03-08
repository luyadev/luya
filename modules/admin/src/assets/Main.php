<?php

namespace admin\assets;

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
}
