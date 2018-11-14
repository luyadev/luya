<?php

namespace luya\web\jsonld;

/**
 * Review
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.14
 */
class Review extends CreativeWork
{
    public function typeDefintion()
    {
        return 'Review';
    }

    private $_itemRevieved;

    /**
     * Set Item Reviewed
     *
     * @param Thing $itemReviewed
     * @return static
     */
    public function setItemReviewed(Thing $itemReviewed)
    {
        $this->_itemRevieved = $itemReviewed;
        return $this;
    }

    /**
     * Get Item Reviewed
     *
     * @return string
     */
    public function getItemReviewed()
    {
        return $this->_itemRevieved;
    }

    private $_reviewAspect;

    /**
     * Set review rating
     *
     * @param string $reviewAspect
     * @return static
     */
    public function setReviewAspect($reviewAspect)
    {
        $this->_reviewAspect = $reviewAspect;
        return $this;
    }

    /**
     * Get review aspect
     *
     * @return string
     */
    public function getReviewAspect()
    {
        return $this->_reviewAspect;
    }

    private $_reviewBody;

    /**
     * Set review body
     *
     * @param string $reviewBody
     * @return static
     */
    public function setReviewBody($reviewBody)
    {
        $this->_reviewBody = $reviewBody;
        return $this;
    }

    /**
     * Get review body
     *
     * @return string
     */
    public function getReviewBody()
    {
        return $this->_reviewBody;
    }

    private $_reviewRating;

    /**
     * Set review rating
     *
     * @param Rating $reviewRating
     * @return static
     */
    public function setReviewRating(Rating $reviewRating)
    {
        $this->_reviewRating = $reviewRating;
        return $this;
    }

    /**
     * Get Review Rating
     *
     * @return Rating
     */
    public function getReviewRating()
    {
        return $this->_reviewRating;
    }
}