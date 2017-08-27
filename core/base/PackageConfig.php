<?php

namespace luya\base;

use yii\base\Object;

class PackageConfig extends Object
{
	public $bootstrap = [];
	
	public $blocks = [];
	
	public $package;
}