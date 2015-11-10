<?php

namespace admin\assets;

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
        'admin\assets\Jquery',
    ];
}
