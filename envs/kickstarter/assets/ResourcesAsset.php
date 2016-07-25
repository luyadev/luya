<?php

namespace app\assets;

class ResourcesAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources';
    
    public $js = [
    	'bootstrap/bootstrap.min.js',
    ];
    
    public $css = [
        'bootstrap/bootstrap.min.css',
        'bootstrap/bootstrap-theme.min.css',
        '//fonts.googleapis.com/css?family=Open+Sans:300,400,600',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        'css/style.css'
    ];
    
    public $publishOptions = [
    	'only' => [
    		'bootstrap/*',
    		'css/*',
    	]
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
