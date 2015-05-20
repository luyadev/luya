<?php

namespace admin;

class _AssetAce extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/ace-builds';

    public $js = [
        'src-min-noconflict/ace.js',
    ];
}
