<?php

namespace luya\web\jsonld;

/**
 * JsonLd Rating.
 *
 * @see http://schema.org/Rating
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class Rating extends BaseThing implements RatingInterface
{
    use RatingTrait;
    
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Rating';
    }
}
