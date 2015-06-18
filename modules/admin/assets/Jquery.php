<?php

namespace admin\assets;

class Jquery extends \luya\base\Asset
{
    public $sourcePath = '@bower';

    public $js = [
        'jquery/dist/jquery.min.js',
        'jquery-ui/jquery-ui.min.js',
    ];
}