<?php

namespace luya\web\jsonld;

use yii\base\Object;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use luya\helpers\StringHelper;

/**
 * Base Thing.
 * 
 * Every JsonLD object must implement BaseThing. Therfore BaseThing auto resolves the fields, in
 * order to provide the Arrayable::fields() methods.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
abstract class BaseThing extends Object implements Arrayable, ThingInterface
{
    use ThingTrait;
    use ArrayableTrait { toArray as protected internalToArray; }
    
    /**
     * Find all getter methods.
     * 
     * @return array
     */
    public function resolveGetterMethods()
    {
    	$resolved = [];
    	$methods = get_class_methods($this);
    	
    	if (!$methods) {
    		return [];
    	}
    	
    	foreach ($methods as $method) {
    		if (StringHelper::startsWith($method, 'get', true)) {
    			$resolved[] = lcfirst(StringHelper::replaceFirst('get', '', $method));
    		}
    	}
    	
    	asort($resolved);
    	
    	return $resolved;
    }
    
    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return $this->removeNullValues($this->internalToArray($fields, $expand, $recursive));
    }
    
    /**
     * @inheritdoc 
     */
    public function fields()
    {
    	return $this->resolveGetterMethods();
    }
    
    /**
     * Cleanup array from null values.
     * 
     * @param array $haystack
     * @return array
     */
    private function removeNullValues(array $haystack)
    {
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $haystack[$key] = $this->removeNullValues($value);
            }
            
            if ($value === null) {
                unset($haystack[$key]);
            }
        }
        
        return $haystack;
    }
}
