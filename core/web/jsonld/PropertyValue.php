<?php

namespace luya\web\jsonld;

/**
 * JsonLd PropertyValue.
 *
 * @see http://schema.org/PropertyValue
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class PropertyValue extends BaseThing implements PropertyValueInterface
{
    use PropertyValueTrait;

    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'PropertyValue';
    }
}
