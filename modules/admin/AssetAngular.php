<?php
namespace admin;

class AssetAngular extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower';

    public $js = [
        'jquery/dist/jquery.min.js',
        'jquery-ui/jquery-ui.min.js',
        'angular/angular.min.js',
        'angular-resource/angular-resource.min.js',
        'angular-ui-router/release/angular-ui-router.min.js',
        'angular-dragdrop/src/angular-dragdrop.min.js',
    ];
}
