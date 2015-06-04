<?php

namespace cmsadmin;

class Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@cmsadmin/assets';

    public $js = [
        'js/directives.js',
        'js/layout.js',
        'js/update.js',
        'js/create.js',
        'js/factorys.js',
    ];

    public $css = [
        'css/cmsadmin.css'
    ];

    public $depends = [
        'admin\AssetAdmin',
    ];
}