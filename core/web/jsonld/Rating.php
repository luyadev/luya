<?php

namespace luya\web\jsonld;

use luya\helpers\ObjectHelper;
use yii\base\InvalidConfigException;


/**
 * JsonLd Rating.
 *
 * @see http://schema.org/Rating
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class Rating extends BaseThing
{
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Rating';
    }

    private $_author;

    /**
     * Set Author
     * 
     * The author of this content or rating. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.
     *
     * @param Organization|Person $author
     * @return static
     */
    public function setAuthor($author)
    {
        ObjectHelper::isInstanceOf($author, [Organization::class, Person::class]);
        $this->_author = $author;
        return $this;
    }

    /**
     * Get Author
     *
     * @return Organization|Person
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    private $_bestRating;

    /**
     * Set best Rating.
     * 
     * The highest value allowed in this rating system. If bestRating is omitted, 5 is assumed.
     *
     * @param integer $bestRating
     * @return static
     */
    public function setBestRating($bestRating)
    {
        $this->_bestRating = $bestRating;
        return $this;
    }

    /**
     * Get best rating
     *
     * @return integer
     */
    public function getBestRating()
    {
        return $this->_bestRating;
    }

    private $_worstRating;

    /**
     * Set Worst Rating.
     *
     * The lowest value allowed in this rating system. If worstRating is omitted, 1 is assumed.
     * 
     * @param integer $worstRating
     * @return static
     */
    public function setWorstRating($worstRating)
    {
        $this->_worstRating = $worstRating;
        return $this;
    }

    /**
     * Get Worst Rating
     *
     * @return integer
     */
    public function getWorstRating()
    {
        return $this->_worstRating;
    }

    private $_ratingValue;

    /**
     * Set Rating Value.
     * 
     * The rating for the content.
     *
     * @param integer $ratingValue
     * @return static
     */
    public function setRatingValue($ratingValue)
    {
        $this->_ratingValue = $ratingValue;
        return $this;
    }

    /**
     * Get Rating Value.
     *
     * @return integer
     */
    public function getRatingValue()
    {
        if ($this->_ratingValue === null) {
            return null;
        }

        $range = new RangeValue($this->_ratingValue);
        $range->ensureRange($this->_worstRating ?: 0, $this->_bestRating ?: 5);

        return $this->_ratingValue = $range->getValue();
    }
    
    private $_reviewAspect;

    /**
     * Set Review Aspect.
     * 
     * This Review or Rating is relevant to this part or facet of the itemReviewed.
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
     * Get Review Aspect.
     *
     * @return string
     */
    public function getReviewAspect()
    {
        return $this->_reviewAspect;
    }
}
