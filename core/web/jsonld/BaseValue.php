<?php

namespace luya\web\jsonld;

/**
 * Represents any value object.
 * 
 * Value objects are used to formate the value of a property.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
abstract class BaseValue
{
    /**
     * Get the value to assign from BaseValue.
     */
    abstract public function getValue();
}