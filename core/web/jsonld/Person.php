<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Person
 *
 * A person (alive, dead, undead, or fictional).
 *
 * @see https://schema.org/Person
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
class Person extends BaseThing implements PersonInterface
{
    use PersonTrait;
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Person';
    }
}
