<?php

namespace luya\cms\base;

/**
 * Interface for all Blocks.
 *
 * The below methods are required in order to create your own block abstraction layer.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
     * The returning array must contain a key where is the field name and a value to display, Example:
     *
     * ```php
     *  return [
     *      'content' => 'An explain example of what this var does it where its displayed.',
     *  ];
     * ```
     *
     * Assuming there is a config var named `content`.
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
    public function getExtraVarValues();
   
    /**
     * Returns all config vars element of key value pairing to pass to the Admin ANGULAR API
     *
     * @return array
     */
    public function getConfigVarsExport();
   
    /**
     * Returns all config cfgs element of key value pairing to pass to the Admin ANGULAR API
     *
     * @return array
     */
    public function getConfigCfgsExport();
    
    /**
     * Returns all config placeholders element of key value pairing to pass to the Admin ANGULAR API
     *
     * @return array
     */
    public function getConfigPlaceholdersExport();
    
    /**
     * Returns the placeholder based rows.
     *
     * This is used to render the grid system in the admin ui.
     *
     * The array which is returned contains rows which contains cols.
     *
     * ```php
     * return [
     *     [], // row 1
     *     [], // row 2
     * ];
     * ```
     *
     * each row can contain columns
     *
     * ```php
     * return [
     *     [ // row 1
     *         ['var' => 'left', 'col' => 6],
     *         ['var' => 'right', 'col' => 6]
     *     ],
     *     [ // row 2
     *         ['var' => 'bottom', 'col' => 12]
     *     ],
     * ];
     * ```
     *
     * @return array Returns an array where each element is a row containing informations about the placeholders.
     */
    public function getConfigPlaceholdersByRowsExport();

    /**
     * Whether cache is enabled for this block or not.
     *
     * @return boolean
     */
    public function getIsCacheEnabled();
    
    /**
     * The time of cache expiration
     *
     * @return integer
     */
    public function getCacheExpirationTime();
    
    /**
     * Whether is an container element or not.
     *
     * @return boolean
     */
    public function getIsContainer();
    
    /**
     * Whether the dirty marker dialog is enable or not.
     *
     * This can be usefull when working with blocks which does not require any input data, so therefore
     * it does not require a drity marked dialog.
     *
     * @return boolean
     */
    public function getIsDirtyDialogEnabled();
}
