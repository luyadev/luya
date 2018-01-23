<?php

namespace luya\web\jsonld;

/**
 * http://schema.org/AggregateRating
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class AggregateRating extends BaseThing implements AggregateRatingInterface
{
    use AggregateRatingTrait;
    
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'AggregateRating';
    }
}