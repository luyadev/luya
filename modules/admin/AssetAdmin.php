<?php
namespace admin;

class AssetAdmin extends \yii\web\AssetBundle
{
    public $sourcePath = '@admin/assets';

    public $css = [
        "//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css",
        "css/main.css",
        "css/style.css",
        //"//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css",

    ];

    public $js = [
        /*
        "//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js", // ja
        "//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular.min.js", // ja
        "//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular-resource.js", // ja
        "//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.11/angular-ui-router.min.js", // ja
        */
        "js/zaa.js",
        "js/login.js",
        "js/factorys.js",
        "js/controllers/MenuController.js",
        "js/controllers/DefaultController.js",
        'js/controllers/CrudController.js',
        'js/directives/crud.js',
        'js/directives/forms.js',
        'js/directives/storage.js',
    ];

    public $depends = [
        'admin\AssetBower',
    ];

    public $publishOptions = ['forceCopy' => true];
}
