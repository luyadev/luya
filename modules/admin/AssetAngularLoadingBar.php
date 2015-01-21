<?php
namespace admin;

class AssetAngularLoadingBar extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/angular-loading-bar';
    
    public $js = [
        "src/loading-bar.js",
    ];
    
    public $css = [
        "src/loading-bar.css"
    ];
}