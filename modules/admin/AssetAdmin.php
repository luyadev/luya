<?php

namespace admin;

class AssetAdmin extends \yii\web\AssetBundle
{
    public $sourcePath = '@admin/assets';

    public $css = [
        'css/admin.css',
    ];

    public $js = [
        'js/zaa.js',
        'js/factorys.js',
        'js/controllers/LayoutMenuController.js',
        'js/controllers/DefaultController.js',
        'js/controllers/ActiveWindowController.js',
        'js/controllers/CrudController.js',
        'js/directives/forms.js',
        'js/directives/storage.js',
        
        'js/materialize.min.js', // original jquery
        'js/ng-materialize.js', // angular wrapper
    ];

    public $depends = [
        'admin\AssetBower',
    ];
}
