<?php

namespace admin\assets;

class Main extends \luya\web\Asset
{
    public $sourcePath = '@admin/resources';

    public $css = [
        '//fonts.googleapis.com/icon?family=Material+Icons',
        'css/admin.css',
    ];

    public $js = [
        'js/lazy-image.min.js', // Lazy loading image
        'js/zaa.js',
        'js/services.js',
        'js/directives.js',
        'js/controllers.js',
    ];

    public $depends = [
        'admin\assets\Jquery',
        'admin\assets\Bower',
    ];
}
