<?php

namespace cmsadmin\base;

use yii\base\Object;

abstract class BlockGroup extends Object
{
    abstract public function identifier();
    
    abstract public function label();
}
