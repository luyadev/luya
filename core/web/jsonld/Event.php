<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Event
 *
 * @see http://schema.org/Event
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
class Event extends BaseThing implements EventInterface
{
    use EventTrait;
}