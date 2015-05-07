<?php

namespace admin;

class AssetBower extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower';

    public $js = [
        'jquery/dist/jquery.min.js',
        'jquery-ui/jquery-ui.min.js',
        'angular/angular.min.js',
        'angular-bootstrap/ui-bootstrap.min.js',
        'angular-bootstrap/ui-bootstrap-tpls.min.js',
        'angular-i18n/angular-locale_de-ch.js',
        'angular-resource/angular-resource.min.js',
        'angular-ui-router/release/angular-ui-router.min.js',
        'angular-dragdrop/src/angular-dragdrop.min.js',
        'twig.js/twig.min.js',
        'ng-flow/dist/ng-flow-standalone.min.js',
    ];
}
