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
abstract class BaseThing extends Object implements Arrayable
{
    use ArrayableTrait;
    
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
    	
    	return $resolved;
    }
    
    /**
     * @inheritdoc 
     */
    public function fields()
    {
    	return $this->resolveGetterMethods();
    }
}
