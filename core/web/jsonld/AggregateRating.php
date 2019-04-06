<?php

namespace luya\web\jsonld;

/**
 * JsonLd AggregateRating.
 *
 * @see http://schema.org/AggregateRating
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class AggregateRating extends Rating
{
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'AggregateRating';
    }

    private $_itemReviewed;

    /**
     * Set item reviewed
     *
     * @param ThingInterface $thing
     * @return static
     */
    public function setItemReviewed(ThingInterface $thing)
    {
        $this->_itemReviewed = $thing;
        return $this;
    }

    /**
     * Getter item reviewed
     *
     * @return ThingInterface
     */
    public function getItemReviewed()
    {
        $this->_itemReviewed;
    }

    private $_ratingCount;

    /**
     * Set rating count
     *
     * @param integer $ratingCount
     * @return static
     */
    public function setRatingCount($ratingCount)
    {
        $this->_ratingCount = (int) $ratingCount;
        return $this;
    }

    /**
     * Get Rating count
     *
     * @return integer
     */
    public function getRatingCount()
    {
        return $this->_ratingCount;
    }

    private $_reviewCount;

    /**
     * Set Review Count
     *
     * @param integer $reviewCount
     * @return static
     */
    public function setReviewCount($reviewCount)
    {
        $this->_reviewCount = (int) $reviewCount;
        return $this;
    }

    /**
     * Get Review count
     *
     * @return integer
     */
    public function getReviewCount()
    {
        return $this->_reviewCount;
    }
}
