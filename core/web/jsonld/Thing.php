<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Thing
 *
 * The most generic type of item.
 *
 * @see https://schema.org/Thing
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
class Thing extends BaseThing
{
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Thing';
    }
}
