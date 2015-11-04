<?php

namespace admin\assets;

class Jquery extends \luya\web\Asset
{
    public $sourcePath = '@bower';

    public $js = [
        'jquery/dist/jquery.min.js',
        'jquery-ui/jquery-ui.min.js',
    ];
}
