<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Organization
 *
 * @see http://schema.org/Organization
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
class Organization extends BaseThing implements OrganizationInterface
{
    public function typeDefintion()
    {
        return 'Organization';
    }
    
    use OrganizationTrait;
}