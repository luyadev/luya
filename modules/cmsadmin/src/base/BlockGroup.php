<?php

namespace cmsadmin\base;

use yii\base\Object;

abstract class BlockGroup extends Object
{
	abstract function identifier();
	
	abstract function label();
}