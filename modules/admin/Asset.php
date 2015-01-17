<?php
namespace admin;

class Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@admin/assets';

    public $css = [
        "//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css",
        "css/main.css",
        "css/style.css",
        //"//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css",

    ];

    public $js = [
        "//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js",
        "//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular.min.js",
        "//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular-resource.js",
        "//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.11/angular-ui-router.min.js",
        "js/zaa.js",
        "js/login.js",
        // "js/admin.js",
        "js/factorys.js",
        "js/controllers/MenuController.js",
        "js/controllers/DefaultController.js",
        'js/controllers/CrudController.js',
        'js/directives/crud.js',
        // 'js/jvfloat.min.js',
        'ace-builds/src-min-noconflict/ace.js',
        'angular-ui-ace/ui-ace.js',
        //"js/ui-bootstrap-tpls-0.11.2.min.js"
    ];

    public $publishOptions = ['forceCopy' => true];
}
