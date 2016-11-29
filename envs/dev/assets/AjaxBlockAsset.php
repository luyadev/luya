<?php

namespace app\assets;

class AjaxBlockAsset extends \luya\web\Asset
{
    public $sourcePath = '@app/resources';
    
    public $js = [
        '//code.jquery.com/jquery-1.11.3.min.js',
        'js/AjaxBlock.js',
    ];
}
