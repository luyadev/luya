<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Place
 *
 * Entities that have a somewhat fixed, physical extension.
 *
 * @see http://schema.org/Place
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
class Place extends BaseThing implements PlaceInterface
{
    use PlaceTrait;
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Place';
    }
}
