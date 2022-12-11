<?php

namespace luya\web\jsonld;

/**
 * JsonLd Offer.
 *
 * @see https://schema.org/Offer
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class Offer extends BaseThing implements OfferInterface
{
    use OfferTrait;

    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Offer';
    }
}
