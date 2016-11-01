<?php

namespace luya\cms\base;

/**
 * Interface for all Blocks.
 * 
 * The below methods are required in order to create your own block abstraction layer.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
interface BlockInterface
{
    // block methods defintions implementations
    
    /**
     * Get the name of the block in order to display in administration context.
     */
    public function name();
    
    /**
     * Returns the icon based on material icon names
     * 
     * @return string
     */
    public function icon();
    
    /**
     * Get the output in the frontend context.
     *
     * @return string
     */
    public function renderFrontend();
    
    /**
     * Get the output in administration context.
     *
     * @return string
     */
    public function renderAdmin();
    
    /**
     * Returns a class of the blocks group.
     *
     * @return \luya\cms\base\BlockGroup
     */
    public function blockGroup();
    
    // getters & setters from outside
    
    /**
     * Returns an array with additional help informations for specific field (var or cfg).
     *
     * @return array An array where the key is the cfg/var field var name and the value the helper text.
     */
    public function getFieldHelp();
    
    /**
     * Set an environment option informations to the block with key value pairing.
     * 
     * @param string $key The identifier key.
     * @param mixed $value The value for the key.
     */
    public function setEnvOption($key, $value);
    
    /**
     * Set the values for element vars with an array key value binding.
     * 
     * @param array $values An array where key is the name of the var-element and value the content.
     */
    public function setVarValues(array $values);
    
    /**
     * Set the values for element cfgs with an array key value binding.
     *
     * @param array $values An array where key is the name of the cfg-element and value the content.
     */
    public function setCfgValues(array $values);
    
    /**
     * Set the value from placeholders where the array key is the name of value the content of the placeholder.
     *
     * @param array $placeholders An array with placeholders where key is name and the value the content e.g. `['content' => 'The placheholder Content']`.
     */
    public function setPlaceholderValues(array $placeholders);
    
    /**
     * Returns an array of key value pairing with additional informations to pass to the API and frontend.
     * 
     * @return array
     */
    public function extraVarsExport();
   
    /**
     * Returns all config vars element of key value pairing to pass to the API and frontend.
     * 
     * @return array
     */
    public function getVarsExport();
   
    /**
     * Returns all config cfgs element of key value pairing to pass to the API and frontend.
     *
     * @return array
     */
    public function getCfgsExport();
    
    /**
     * Returns all config placeholders element of key value pairing to pass to the API and frontend.
     * 
     * @return array
     */
    public function getPlaceholdersExport();

    /**
     * Whether cache is enabled for this block or not.
     * 
     * @return boolean
     */
    public function getIsCacheEnabled();
    
    /**
     * The time of cache expiration
     */
    public function getCacheExpirationTime();
    
    /**
     * Whether is an container element or not.
     */
    public function getIsContainer();
}
