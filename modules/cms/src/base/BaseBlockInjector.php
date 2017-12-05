<?php

namespace luya\cms\base;

use yii\base\InvalidConfigException;
use yii\base\BaseObject;

/**
 * The base injector class for all Injectors.
 *
 * An example of using an injector inside a block:
 *
 * ```php
 * public function injectors()
 * {
 *     return [
 *         'myvariable' => new Injector([
 *             'varLabel' => 'My Label',
 *             'type' => 'cfg',
 *         ]),
 *     ];
 * }
 * ```
 *
 * By defintion the injector is now available under the variable name `myvariable` inside the extra
 * vars variables definitions `$extra['myvariable']`.
 *
 * @property \luya\cms\base\BlockInterface $context The context block object where the injector is placed.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class BaseBlockInjector extends BaseObject
{
    /**
     * @var string The name of the variable on what the injector should use and listen to.
     */
    public $varName;
    
    /**
     * @var string The label used in the administration area for this injector.
     */
    public $varLabel;
    
    /**
     * @var string The type of variable is used for the inject. can be either var or cfg.
     */
    public $type = InternalBaseBlock::INJECTOR_VAR;
    
    /**
     * @var boolean Whether the variable should be at the start (prepand) or end (append) of the configration.
     */
    public $append = false;
    
    private $_context;
    
    /**
     * Setter for the context value must be typeof BlockInterface.
     *
     * @param \luya\cms\base\BlockInterface $context The block context which will be injected on setup.
     */
    public function setContext(BlockInterface $context)
    {
        $this->_context = $context;
    }
    
    /**
     * Getter for the context variable on where the block is injected.
     *
     * @return \luya\cms\base\BlockInterface
     */
    public function getContext()
    {
        return $this->_context;
    }

    /**
     * Returns the value of the variable which is defined for this injector object based on it given type.
     *
     * @param string $varName
     * @param mixed $defaultValue The default value for the variable if not found.
     * @return mixed
     * @throws InvalidConfigException
     */
    public function getContextConfigValue($varName, $defaultValue = null)
    {
        if ($this->type == InternalBaseBlock::INJECTOR_VAR) {
            return $this->context->getVarValue($varName, $defaultValue);
        }
        
        if ($this->type == InternalBaseBlock::INJECTOR_CFG) {
            return $this->context->getCfgValue($varName, $defaultValue);
        }
            
        throw new InvalidConfigException("The type '{$this->type}' is not supported.");
    }
    
    /**
     * Set a new configuration value for a variable based on its context (cfg or var).
     *
     * @param array $config The config of the variable to inject
     * @throws InvalidConfigException
     */
    public function setContextConfig(array $config)
    {
        if ($this->type == InternalBaseBlock::INJECTOR_VAR) {
            return $this->context->addVar($config, $this->append);
        }
         
        if ($this->type == InternalBaseBlock::INJECTOR_CFG) {
            return $this->context->addCfg($config, $this->append);
        }
        
        throw new InvalidConfigException("The type '{$this->type}' is not supported.");
    }
    
    /**
     * The setup method which all injectors must implement. The setup method is mainly to
     * inject the variable into the configs and setting up the extra vars values.
     */
    abstract public function setup();
}
