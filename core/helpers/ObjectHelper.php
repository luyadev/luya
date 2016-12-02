<?php

namespace luya\helpers;

use luya\Exception;
use ReflectionMethod;

/**
 * Helpers when working with Objects.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ObjectHelper
{
    /**
     * Convert Object to Array
     *
     * @since 1.0.0-beta7
     * @param object $object
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
     * @param object $object The class object where the method must be found.
     * @param string $method The class method to call inside the object.
     * @param array  $argumentsList A massiv assigned list of array items, where the key is bind to the method argument and the value to be passed in the method on call.
     * @throws \luya\Exception Throws an exception if a argument coult not be found.
     * @return object
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
}
