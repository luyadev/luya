<?php

namespace luya\web\jsonld;

/**
 * JsonLd Country.
 *
 * @see http://schema.org/Country
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class Country extends BaseThing implements CountryInterface
{
    use CountryTrait;

    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Country';
    }
}
