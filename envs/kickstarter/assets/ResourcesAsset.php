<?php

namespace app\assets;

class ResourcesAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources';
    
    public $css = [
        'bootstrap/css/bootstrap.min.css',
        'bootstrap/css/bootstrap-theme.min.css',
        'css/style.css'
    ];
}