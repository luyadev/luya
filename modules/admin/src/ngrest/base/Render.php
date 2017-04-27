<?php

namespace luya\admin\ngrest\base;

use yii\base\Object;
use luya\admin\ngrest\ConfigInterface;

/**
 * NgRest base rendere which is used in all ngrest render classes.
 *
 * @property \luya\admin\ngrest\ConfigInterface
 * 
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Render extends Object
{
	private $_config; 
	
    public function getConfig()
    {
    	return $this->_config;
    }
    
    public function setConfig(ConfigInterface $config)
    {
        $this->_config = $config;
    }
}
