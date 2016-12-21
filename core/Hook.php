<?php

namespace luya;

use yii\base\Object;
use luya\base\HookEvent;

/**
 * Simple Hooking mechanism.
 * 
 * Attaching callables or object methods to the Hook mechnism in your controller, block or elsewhere.
 * 
 * A simple string output behavior:
 * 
 * ```php
 * Hook::on('fooBar', function() {
 *     return 'Hello World';
 * });
 * ```
 * 
 * In order to trigger the hook output somewher in your layout file use:
 * 
 * ```php
 * echo Hook::string('fooBar');
 * ```
 * 
 * In order to generate iteration output.
 * 
 * ```php
 * Hook::on('fooBarArray', function($hook) {
 *     $hook[] = 'Hello';
 *     $hook[] = 'World';
 * });
 * ```
 * 
 * The array would print:
 * 
 * ```php
 * $array = Hook::iterate('fooBarArray'); // Array ( 0 => 'Hello', 1 => 'World')
 * ```
 * 
 * @since 1.0.0
 * @author Basil Suter <basil@nadar.io>
 */
class Hook extends Object
{
    private static $_hooks = [];

    /**
     * Register a hook listener.
     * 
     * Define the name of the type of listener.
     * 
     * @param string $name The name of the hook.
     * @param callable|array $value An array with `[$object, 'method']` or a callable function `function($hook) {}`.
     * @param boolean $prepend Whether to prepend the item to the start or not, defaults to false.
     */
    public static function on($name, $value, $prepend = false)
    {
        /// @TODO implement prepend
        static::$_hooks[$name][] = new HookEvent(['handler' => $value]);
    }

    /**
     * Trigger the hooks and returns the {{luya\base\HookEvent}} objects.
     * 
     * @param string $name The hook name.
     * @return array An array with {{luya\base\HookEvent}} objects.
     */
    protected static function trigger($name)
    {
        if (isset(static::$_hooks[$name])) {
            
            $events = [];
            
            foreach (static::$_hooks[$name] as $hookEvent) {
               
                if ($hookEvent->isHandled) {
                    continue;
                }
                
                if (is_callable($hookEvent->handler)) {
                    $hookEvent->output = call_user_func($hookEvent->handler, $hookEvent);
                } elseif (is_array($hookValue)) {
                    $hookEvent->output = call_user_func_array($hookEvent->handler, [$hookEvent]);
                }
                
                $hookEvent->isHandled = true;
                
                if ($hookEvent->isValid) {
                    $events[] = $hookEvent;
                }
            }

            return $events;
        }

        return [];
    }
    
    /**
     * Get the string output of the hooks.
     * 
     * @param string $name The name of the hook to trigger.
     * @return string
     */
    public static function string($name)
    {
        $buffer = [];
        foreach (self::trigger($name) as $hook) {
            $buffer[] = $hook->output;
        }
        
        return implode("", $buffer);
    }
    
    /**
     * Get the array output of iteration hooks.
     * 
     * @param string $name The name of the hook to trigger.
     * @return array
     */
    public static function iterate($name)
    {
        $buffer = [];
        foreach (self::trigger($name) as $hook) {
            $buffer = array_merge($buffer, $hook->getIterations());
        }
        
        return $buffer;
    }
}