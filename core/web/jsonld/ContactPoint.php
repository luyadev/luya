<?php

namespace luya\web\jsonld;

/**
 * JsonLd ContactPoint.
 * 
 * @see http://schema.org/ContactPoint
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class ContactPoint extends BaseThing implements ContactPointInterface
{
    use ContactPointTrait;
    
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'ContactPoint';
    }
}