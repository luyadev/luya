<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Person
 *
 * @see http://schema.org/Person
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
class Person extends BaseThing implements ThingInterface, PersonInterface
{
    use PersonTrait;
}
