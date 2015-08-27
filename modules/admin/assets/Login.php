<?php

namespace admin\assets;

class Login extends \luya\base\Asset
{
    public $sourcePath = '@admin/resources';

    public $css = [
        'css/admin.css',
    ];

    public $js = [
        'js/materialize.min.js',
    ];

    public $depends = [
        'admin\assets\Jquery',
    ];
}
