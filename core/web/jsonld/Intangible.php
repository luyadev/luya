<?php
namespace luya\web\jsonld;

/**
 * JsonLd - Intangible
 *
 * A utility class that serves as the umbrella for a number of 'intangible' things such as quantities, structured values, etc.
 *
 * @see http://schema.org/Intangible
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.19
 */
class Intangible extends BaseThing implements IntangibleInterface
{
    /**
     * @inheritDoc
     */
    public function typeDefintion()
    {
        return 'Intangible';
    }

    use IntangibleTrait;
}