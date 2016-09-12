<?php

namespace luya\cms\base;

use yii\base\Object;
use luya\cms\base\BlockInterface;
use luya\cms\base\InternalBaseBlock;
use yii\base\InvalidConfigException;

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
 * @since 1.0.0-rc1
 * @author Basil Suter <basil@nadar.io>
 */
abstract class BaseBlockInjector extends Object
{
    /**
     * @var string The name of the variable on what the injector should use and listen to.
     */
    public $varName = null;
    
    /**
     * @var string The label used in the administration area for this injector.
     */
    public $varLabel = null;
    
    /**
     * @var string The type of variable is used for the inject. can be either var or cfg.
     */
    public $type = InternalBaseBlock::VAR_INJECTOR;
    
    private $_context = null;
    
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
     * @param mixed $defaultValue The default value for the variable if not found.
     * @throws InvalidConfigException
     */
    public function getContextConfigValue($varName, $defaultValue = null)
    {
        if ($this->type == InternalBaseBlock::VAR_INJECTOR) {
            return $this->context->getVarValue($varName, $defaultValue);
        }
        
        if ($this->type == InternalBaseBlock::CFG_INJECTOR) {
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
        if ($this->type == InternalBaseBlock::VAR_INJECTOR) {
            return $this->context->addVar($config);
        }
         
        if ($this->type == InternalBaseBlock::CFG_INJECTOR) {
            return $this->context->addCfg($config);
        }
        
        throw new InvalidConfigException("The type '{$this->type}' is not supported.");
    }
    
    /**
     * The setup method which all injectors must implement. The setup method is mainly to
     * inject the variable into the configs and setting up the extra vars values.
     */
    abstract public function setup();
}
