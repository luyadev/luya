<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Event
 *
 * An event happening at a certain time and location, such as a concert, lecture, or festival.
 * Ticketing information may be added via the offers property.
 * Repeated events may be structured as separate Event objects.
 *
 * @see http://schema.org/Event
 *
 * @author Alex Schmid
 * @since 1.0.0
 */
class Event extends BaseThing implements EventInterface
{
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Event';
    }
    
    use EventTrait;
}
