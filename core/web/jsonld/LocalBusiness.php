<?php

namespace luya\web\jsonld;

/**
 * Local Business
 * 
 * @see https://schema.org/LocalBusiness
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
class LocalBusiness extends Organization implements LocalBusinessInterface
{
    use LocalBusinessTrait;

    /**
     * {@inheritDoc}
     */
    public function typeDefintion()
    {
        return 'LocalBusiness';
    }
}