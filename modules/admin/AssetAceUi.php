<?php
namespace admin;

class AssetAceUi extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/angular-ui-ace';
    
    public $js = [
        'ui-ace.js'
    ];
}