<?php

namespace luya\web\jsonld;

use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use luya\helpers\StringHelper;
use yii\base\BaseObject;

/**
 * Base Thing.
 *
 * Every JsonLD object must implement BaseThing. Therfore BaseThing auto resolves the fields, in
 * order to provide the Arrayable::fields() methods.
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class BaseThing extends BaseObject implements Arrayable, ThingInterface
{
    use ThingTrait;
    
    use ArrayableTrait { toArray as protected internalToArray; }
    
    /**
     * Contains the jsonLd definton @type value if not null or false.
     *
     * @return boolean|string Generates the @type field.
     */
    public function typeDefintion()
    {
        return false;
    }
    
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
        $array = $this->removeEmptyValues($this->internalToArray($fields, $expand, $recursive));
        
        if ($this->typeDefintion()) {
            $array['@type'] = $this->typeDefintion();
        }
        
        return $array;
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
    private function removeEmptyValues(array $haystack)
    {
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $haystack[$key] = $this->removeEmptyValues($value);
            }
            // remove empty values value value is NULL or an empty string ''
            if ($value === null || $value === '') {
                unset($haystack[$key]);
            }
        }
        
        return $haystack;
    }
}
