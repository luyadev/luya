<?php
namespace cmsadmin;

class Asset extends \yii\web\AssetBundle
{
    public $sourcePath = '@cmsadmin/assets';

    public $js = [
        "js/cmsadmin.js",
        "js/update.js",
        "js/factorys.js",
        "bower_components/angular-dragdrop/src/angular-dragdrop.min.js",
        "bower_components/jquery-ui/jquery-ui.min.js",
    ];

    public $publishOptions = ['forceCopy' => true];
}
