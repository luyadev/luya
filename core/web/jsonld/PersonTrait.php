<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Person trait
 *
 * @see http://schema.org/Person
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
trait PersonTrait
{
    use ThingTrait {
        fields as thingFields;
    }

    /**
     * Return the fields
     */
    public function fields()
    {
        return $this->thingFields();
    }
}