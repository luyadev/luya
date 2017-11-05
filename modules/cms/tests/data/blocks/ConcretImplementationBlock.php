<?php

namespace cmstests\data\blocks;

use luya\cms\base\BlockInterface;
use luya\cms\frontend\blockgroups\DevelopmentGroup;

class ConcretImplementationBlock implements BlockInterface
{
    /**
     * Get the name of the block in order to display in administration context.
     */
    public function name()
    {
        return 'Concrept Block';
    }
    
    /**
     * Returns the configuration array.
     *
     * @return array
     */
    public function config()
    {
        return [];
    }
    
    /**
     * Returns the icon based on material icon names
     *
     * @return string
     */
    public function icon()
    {
        return '<i class="fa fa-icon">icon</i>';
    }
    
    /**
     * Get the output in the frontend context.
     *
     * @return string
     */
    public function renderFrontend()
    {
        return 'frontend!';
    }
    
    /**
     * Get the output in administration context.
     *
     * @return string
     */
    public function renderAdmin()
    {
        return 'admin!';
    }
    
    /**
     * Returns a class of the blocks group.
     *
     * @return \luya\cms\base\BlockGroup
     */
    public function blockGroup()
    {
        return DevelopmentGroup::class;
    }
    
    // getters & setters from outside

    
    /**
     * Returns an array with additional help informations for specific field (var or cfg).
     *
     * @return array An array where the key is the cfg/var field var name and the value the helper text.
     */
    public function getFieldHelp()
    {
        return [];
    }
    
    private $_envs = [];
    
    /**
     * Set an environment option informations to the block with key value pairing.
     *
     * @param string $key The identifier key.
     * @param mixed $value The value for the key.
     */
    public function setEnvOption($key, $value)
    {
        $this->_envs[$key] = $value;
    }
    
    private $_vars;
    
    /**
     * Set the values for element vars with an array key value binding.
     *
     * @param array $values An array where key is the name of the var-element and value the content.
     */
    public function setVarValues(array $values)
    {
        $this->_vars = $values;
    }
    
    private $_cfgs = [];
    
    /**
     * Set the values for element cfgs with an array key value binding.
     *
     * @param array $values An array where key is the name of the cfg-element and value the content.
     */
    public function setCfgValues(array $values)
    {
        $this->_cfgs = $values;
    }
    
    private $_placeholders = [];
    
    /**
     * Set the value from placeholders where the array key is the name of value the content of the placeholder.
     *
     * @param array $placeholders An array with placeholders where key is name and the value the content e.g. `['content' => 'The placheholder Content']`.
     */
    public function setPlaceholderValues(array $placeholders)
    {
        $this->_placeholders = $placeholders;
    }
    
    /**
     * Returns an array of key value pairing with additional informations to pass to the API and frontend.
     *
     * @return array
     */
    public function getExtraVarValues()
    {
        return ['foo' => 'bar'];
    }
     
    /**
     * Returns all config vars element of key value pairing to pass to the API and frontend.
     *
     * @return array
     */
    public function getConfigVarsExport()
    {
        return [];
    }
     
    /**
     * Returns all config cfgs element of key value pairing to pass to the API and frontend.
     *
     * @return array
     */
    public function getConfigCfgsExport()
    {
        return [];
    }
    
    /**
     * Returns all config placeholders element of key value pairing to pass to the API and frontend.
     *
     * @return array
     */
    public function getConfigPlaceholdersExport()
    {
        return [];
    }

    public function getConfigPlaceholdersByRowsExport()
    {
        return [];
    }
    
    /**
     * Whether cache is enabled for this block or not.
     *
     * @return boolean
     */
    public function getIsCacheEnabled()
    {
        return false;
    }
    
    /**
     * The time of cache expiration
     */
    public function getCacheExpirationTime()
    {
        return 60;
    }
    
    /**
     * Whether is an container element or not.
     */
    public function getIsContainer()
    {
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function getIsDirtyDialogEnabled()
    {
        return true;
    }
}
