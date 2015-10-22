<?php

namespace admin\assets;

class Login extends \luya\base\Asset
{
    public $sourcePath = '@admin/resources';

    public $css = [
        '//fonts.googleapis.com/icon?family=Material+Icons',
        'css/admin.css',
    ];

    public $js = [
        'js/materialize.min.js',
        'js/login.js',
    ];

    public $depends = [
        'admin\assets\Jquery',
    ];
}
