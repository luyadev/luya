<?php

namespace luya\admin\assets;

/**
 * Login Asset contains all required files for the administration login screen.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Login extends \luya\web\Asset
{
    public $sourcePath = '@admin/resources';

    public $css = [
        '//fonts.googleapis.com/icon?family=Material+Icons',
        'css/admin.css',
        'css/login.css',
    ];

    public $js = [
        //'js/materialize.min.js',
        'js/login.js',
    ];

    public $depends = [
        'luya\admin\assets\Jquery',
    ];
    
    /*
    public $publishOptions = [
        'only' => [
            'js/*',
            'css/*',
            'img/*',
        ]
    ];
    */
}
