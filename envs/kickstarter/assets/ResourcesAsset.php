<?php

namespace app\assets;

/**
 * Application Asset File.
 */
class ResourcesAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources';
    
    public $js = [
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
    ];
    
    public $css = [
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        '//fonts.googleapis.com/css?family=Open+Sans:300,400,600',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        'css/style.css'
    ];
    
    public $publishOptions = [
        'only' => [
            'css/*',
            'js/*',
        ]
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
