<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Creative Work
 *
 * @see http://schema.org/CreativeWork
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
class CreativeWork extends BaseThing implements CreativeWorkInterface
{
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'CreativeWork';
    }

    use CreativeWorkTrait;
}