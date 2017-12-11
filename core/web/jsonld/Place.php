<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Place
 *
 * @see http://schema.org/Place
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
class Place extends BaseThing implements PlaceInterface
{
    public function typeDefintion()
    {
        return 'Place';
    }
    
    use PlaceTrait;
}
