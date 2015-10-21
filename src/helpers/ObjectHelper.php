<?php

namespace luya\helpers;

use Exception;
use ReflectionMethod;

class ObjectHelper
{
    public static function callMethodSanitizeArguments($object, $method, array $argumentsList = [])
    {
        $reflection = new ReflectionMethod($object, $method);
        
        $methodArgs = [];
        
        if ($reflection->getNumberOfRequiredParameters() > 0) {
            foreach ($reflection->getParameters() as $param) {
                if (!array_key_exists($param->name, $argumentsList)) {
                    throw new Exception("The provided argument '".$param->name."' does not exist in argument list for method '$method'.");
                }
                $methodArgs[] = $argumentsList[$param->name];
            }
        }
        
        return call_user_func_array(array($object, $method), $methodArgs);
    }
}