<?php

namespace luya\helpers;

use Exception;
use ReflectionMethod;

/**
 * ObjectHelper to provied helper methods with class objects.
 *
 * @author nadar
 */
class ObjectHelper
{
    /**
     * Call a class method with arguments and verify the arguments if they are in the list of
     * method arguments or not.
     * 
     * @param object $object        The class object where the method must be found.
     * @param string $method        The class method to call inside the object
     * @param array  $argumentsList A massiv assigned list of array items, where the key is bind
     *                              to the method argument and the value to be passed in the method on call.
     *
     * @throws Exception Throws an exception if a argument coult not be found.
     *
     * @return object
     */
    public static function callMethodSanitizeArguments($object, $method, array $argumentsList = [])
    {
        // get class refelction object
        $reflection = new ReflectionMethod($object, $method);
        // array where the sanitized arguemnts will be stored
        $methodArgs = [];
        // get all parematers of the $method
        if ($reflection->getNumberOfRequiredParameters() > 0) {
            foreach ($reflection->getParameters() as $param) {
                if (!array_key_exists($param->name, $argumentsList)) {
                    throw new Exception("The provided argument '".$param->name."' does not exist in argument list for method '$method'.");
                }
                $methodArgs[] = $argumentsList[$param->name];
            }
        }
        // call the object with method and arguments.
        return call_user_func_array([$object, $method], $methodArgs);
    }
}
