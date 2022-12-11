<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Organization
 *
 * An organization such as a school, NGO, corporation, club, etc.
 *
 * @see https://schema.org/Organization
 * @author Alex Schmid
 * @since 1.0.0
 */
class Organization extends BaseThing implements OrganizationInterface
{
    use OrganizationTrait;
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Organization';
    }
}
