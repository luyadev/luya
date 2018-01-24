<?php

namespace luya\web\jsonld;

/**
 * JsonLd PostalAddress.
 *
 * @see http://schema.org/PostalAddress
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class PostalAddress extends BaseThing implements PostalAddressInterface
{
    use PostalAddressTrait;
    
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'PostalAddress';
    }
}
