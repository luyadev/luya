<?php

namespace luya\admin\ngrest\base;

use yii\base\Object;
use luya\admin\ngrest\ConfigInterface;

/**
 * NgRest base rendere which is used in all ngrest render classes.
 *
 * @property \luya\admin\ngrest\ConfigInterface $config
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Render extends Object
{
    private $_config;
    
    /**
     * Get current config Context.
     *
     * @return \luya\admin\ngrest\ConfigInterface
     */
    public function getConfig()
    {
        return $this->_config;
    }
    
    /**
     * Set current config Context.
     *
     * @param \luya\admin\ngrest\ConfigInterface $config
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->_config = $config;
    }
}
