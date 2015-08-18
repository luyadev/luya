<?php

namespace admin\assets;

class Main extends \luya\base\Asset
{
    public $sourcePath = '@admin/resources';

    public $css = [
        'css/admin.css',
    ];

    public $js = [
        'js/materialize.min.js', // original jquery
        'js/ng-materialize.js', // angular wrapper
        'js/zaa.js',
        'js/directives.js',
        'js/controllers.js',
        /*
        'js/factorys.js',
        'js/controllers/LayoutMenuController.js',
        'js/controllers/DefaultController.js',
        'js/controllers/ActiveWindowController.js',
        'js/controllers/CrudController.js',
        'js/directives/forms.js',
        'js/directives/storage.js',
        */
    ];

    public $depends = [
        'admin\assets\Jquery',
        'admin\assets\Bower',
    ];
}
