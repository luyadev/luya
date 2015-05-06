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
        'angular-pickadate/dist/angular-pickadate.min.js',
        'twig.js/twig.min.js',
        'ng-flow/dist/ng-flow-standalone.min.js',
    ];

    public $css = [
        'angular-pickadate/dist/angular-pickadate.css',
    ];
}
