<?php

namespace admin\assets;

use luya\web\Asset;

class Flow extends Asset
{
    public $sourcePath = '@admin/resources/flow';
    
    public $js = [
        'ng-flow-standalone.min.js',
    ];
    
    public $depends = [
        'admin\assets\Main',
    ];
}