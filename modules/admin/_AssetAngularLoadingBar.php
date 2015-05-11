<?php

namespace admin;

class _AssetAngularLoadingBar extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/angular-loading-bar';

    public $js = [
        'build/loading-bar.min.js',
    ];

    public $css = [
        'build/loading-bar.min.css',
    ];
}
