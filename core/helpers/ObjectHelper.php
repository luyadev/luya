<?php

namespace luya\helpers;

use ReflectionClass;
use ReflectionMethod;
use luya\Exception;
use yii\base\Controller;
use luya\base\Module;

/**
 * Helper methods when dealing with Objects.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ObjectHelper
{
    /**
     * Checks a given variable if its an instance of an element in the $instances list.
     *
     * ```php
     * $object = new \Exception();
     * 
     * ObjectHelper::isInstanceOf($object, '\Exception');
     * ```
     * 
     * @param object $object The object to type check against haystack.
     * @param string|array|object $haystack A list of classes, a string for a given class, or an object.
     * @param boolean $throwException Whether an exception should be thrown or not.
     * @throws \luya\Exception
     * @return boolean
     * @since 1.0.3
     */
    public static function isInstanceOf($object, $haystack, $throwException = true)
    {
        // if instances is an object (compare object directly) we have to get the class name to compare with instanceof later
        if (is_object($haystack)) {
            $haystack = get_class($haystack);
        }
        
        $haystack = (array) $haystack;
        
        foreach ($haystack as $class) {
            if ($object instanceof $class) {
                return true;
            }
        }
        
        if ($throwException) {
            throw new Exception("The given object must be an instance of: " . implode(",", $haystack));
        }
        
        return false;
    }

    /**
     * Check whether a given object contains a trait.
     * 
     * ```php
     * trait XYZ {
     * 
     * }
     * 
     * class ABC {
     *    use XYZ;
     * }
     * 
     * $object = new ABC();
     * 
     * ObjectHelper::isTraitInstanceOf($object, XYZ::class);
     * ```
     *
     * @param object $object
     * @param string|array|object $haystack
     * @return boolean
     * @since 1.0.17
     */
    public static function isTraitInstanceOf($object, $haystack)
    {
        $traits = static::traitsList($object);

        // if its an object, the all traits for the given object.
        if (is_object($haystack)) {
            $haystack = static::traitsList($haystack);
        }

        foreach ((array) $haystack as $stack) {
            if (in_array($stack, $traits)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get an array with all traits for a given object
     *
     * @param object $object
     * @param boolean $autoload
     * @return array
     * @since 1.0.17
     * @see https://www.php.net/manual/en/function.class-uses.php#122427
     */
    public static function traitsList($object, $autoload = true)
    {
        $traits = [];

        // Get traits of all parent classes
        do {
            $traits = array_merge(class_uses($object, $autoload), $traits);
        } while ($object = get_parent_class($object));

        // Get traits of all parent traits
        $traitsToSearch = $traits;
        while (!empty($traitsToSearch)) {
            $newTraits = class_uses(array_pop($traitsToSearch), $autoload);
            $traits = array_merge($newTraits, $traits);
            $traitsToSearch = array_merge($newTraits, $traitsToSearch);
        };

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }

        return $traits;
    }
    
    /**
     * Convert Object to Array
     *
     * @param object $object
     * @return array
     */
    public static function toArray($object)
    {
        return (array) $object;
    }
    
    /**
     * Call a method and ensure arguments.
     *
     * Call a class method with arguments and verify the arguments if they are in the list of method arguments or not.
     *
     * ```php
     * ObjectHelper::callMethodSanitizeArguments(new MyClass(), 'methodToCall', ['paramName' => 'paramValue']);
     * ```
     *
     * The response is the return value from the called method of the object.
     *
     * @param object $object The class object where the method must be found.
     * @param string $method The class method to call inside the object.
     * @param array $argumentsList A massiv assigned list of array items, where the key is bind to the method argument and the value to be passed in the method on call.
     * @throws \luya\Exception Throws an exception if a argument coult not be found.
     * @return mixed
     */
    public static function callMethodSanitizeArguments($object, $method, array $argumentsList = [])
    {
        // get class reflection object
        $reflection = new ReflectionMethod($object, $method);
        // array where the sanitized arguemnts will be stored
        $methodArgs = [];

        foreach ($reflection->getParameters() as $param) {
            // add the argument into the method list when existing
            if (array_key_exists($param->name, $argumentsList)) {
                $methodArgs[] = $argumentsList[$param->name];
            }
            // check if the provided arguemnt is optional or not
            if (!$param->isOptional() && !array_key_exists($param->name, $argumentsList)) {
                throw new Exception(sprintf("The argument '%s' is required for method '%s' in class '%s'.", $param->name, $method, get_class($object)));
            }
        }

        return call_user_func_array([$object, $method], $methodArgs);
    }

    /**
     * Get all actions from a given controller.
     *
     * @param Controller $controller
     * @return array
     * @since 1.0.19
     */
    public static function getActions(Controller $controller)
    {
        $actions = array_keys($controller->actions());
        $class = new ReflectionClass($controller);
        foreach ($class->getMethods() as $method) {
            $name = $method->getName();
            if ($name !== 'actions' && $method->isPublic() && !$method->isStatic() && strncmp($name, 'action', 6) === 0) {
                $actions[] = Inflector::camel2id(substr($name, 6), '-', true);
            }
        }
        sort($actions);
        return array_unique($actions);
    }

    /**
     * Get all controllers for a given luya Module
     *
     * @param Module $module
     * @return array
     * @since 1.0.19
     */
    public static function getControllers(Module $module)
    {
        $files = [];

        try { // https://github.com/yiisoft/yii2/blob/master/framework/base/Module.php#L253
            if (is_dir($module->controllerPath)) {
                foreach (FileHelper::findFiles($module->controllerPath) as $file) {
                    $files[self::fileToName($module->controllerPath, $file)] = $file;
                }
            }
        } catch (InvalidParamException $e) {
            
        };

        $staticPath = $module::staticBasePath() . DIRECTORY_SEPARATOR . 'controllers';
        if (is_dir($staticPath)) {
            foreach (FileHelper::findFiles($staticPath) as $file) {
                $files[self::fileToName($staticPath, $file)] = $file;
            }
        }
        
        return $files;
    }

    /**
     * Namify a controller file
     *
     * @param string $prefix
     * @param string $file
     * @return string
     * @since 1.0.19
     */
    private static function fileToName($prefix, $file)
    {
        return Inflector::camel2id(ltrim(str_replace([$prefix, 'Controller.php'], '', $file), DIRECTORY_SEPARATOR));
    }
}
