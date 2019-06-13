<?php
namespace luya\web\jsonld;

/**
 * JsonLd - Service
 *
 * A service provided by an organization, e.g. delivery service, print services, etc.
 *
 * @see http://schema.org/Service
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.19
 */
class Service extends Intangible implements ServiceInterface
{
    use ServiceTrait;

    /**
     * {@inheritDoc}
     */
    public function typeDefintion()
    {
        return 'Service';
    }
}