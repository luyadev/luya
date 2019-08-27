<?php
namespace luya\web\jsonld;

/**
 * JsonLd - Live Blog Posting trait
 *
 * @see http://schema.org/LiveBlogPosting
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
trait LiveBlogPostingTrait
{
    use BlogPostingTrait;

    private $_coverageEndTime;

    /**
     * @return string
     */
    public function getCoverageEndTime()
    {
        return $this->_coverageEndTime;
    }

    /**
     * The time when the live blog will stop covering the Event. Note that coverage may continue after the Event concludes.
     *
     * @param DateTimeValue $coverageEndTime
     * @return static
     */
    public function setCoverageEndTime(DateTimeValue $coverageEndTime)
    {
        $this->_coverageEndTime = $coverageEndTime->getValue();
        return $this;
    }

    private $_coverageStartTime;

    /**
     * @return string
     */
    public function getCoverageStartTime()
    {
        return $this->_coverageStartTime;
    }

    /**
     * The time when the live blog will begin covering the Event. Note that coverage may begin before the Event's start time.
     * The LiveBlogPosting may also be created before coverage begins.
     *
     * @param DateTimeValue $coverageStartTime
     * @return static
     */
    public function setCoverageStartTime(DateTimeValue $coverageStartTime)
    {
        $this->_coverageStartTime = $coverageStartTime->getValue();
        return $this;
    }

    private $_liveBlogUpdate;

    /**
     * @return BlogPosting
     */
    public function getLiveBlogUpdate()
    {
        return $this->_liveBlogUpdate;
    }

    /**
     * An update to the LiveBlog.
     *
     * @param BlogPosting $liveBlogUpdate
     * @return static
     */
    public function setLiveBlogUpdate(BlogPosting $liveBlogUpdate)
    {
        $this->_liveBlogUpdate = $liveBlogUpdate;
        return $this;
    }
}
