<?php

namespace admin;

class AssetBower extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower';

    public $js = [
        'jquery/dist/jquery.min.js',
        'jquery-ui/jquery-ui.min.js',
        'angular/angular.min.js',
        'angular-i18n/angular-locale_de-ch.js',
        'angular-resource/angular-resource.min.js',
        'angular-ui-router/release/angular-ui-router.min.js',
        'angular-dragdrop/src/angular-dragdrop.min.js',
        'angular-loading-bar/build/loading-bar.min.js',
        'ng-flow/dist/ng-flow-standalone.min.js',
        'twig.js/twig.min.js',
        'ng-wig/dist/ng-wig.min.js',
        
        // ace
        // 'ace-builds/src-min-noconflict/ace.js', // "bower-asset/angular-ui-ace" : "0.*@stable",
        // 'angular-ui-ace/ui-ace.js', // "bower-asset/ace-builds" : "1.1.8@stable",
    ];
    
    public $css = [
        'angular-loading-bar/build/loading-bar.min.css',
        'ng-wig/dist/css/ng-wig.css'
    ];
}