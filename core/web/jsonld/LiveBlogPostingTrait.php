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

    /**
     * The time when the live blog will stop covering the Event. Note that coverage may continue after the Event concludes.
     *
     * @var DateTime
     */
    private $_coverageEndTime;

    /**
     * @return DateTime
     */
    public function getCoverageEndTime()
    {
        return $this->_coverageEndTime;
    }

    /**
     * @param DateTime $coverageEndTime
     * @return LiveBlogPosting|LiveBlogPostingTrait
     */
    public function setCoverageEndTime($coverageEndTime)
    {
        $this->_coverageEndTime = $coverageEndTime;
        return $this;
    }

    /**
     * The time when the live blog will begin covering the Event. Note that coverage may begin before the Event's start time.
     * The LiveBlogPosting may also be created before coverage begins.
     *
     * @var DateTime
     */
    private $_coverageStartTime;

    /**
     * @return DateTime
     */
    public function getCoverageStartTime()
    {
        return $this->_coverageStartTime;
    }

    /**
     * @param DateTime $coverageStartTime
     * @return LiveBlogPosting|LiveBlogPostingTrait
     */
    public function setCoverageStartTime($coverageStartTime)
    {
        $this->_coverageStartTime = $coverageStartTime;
        return $this;
    }

    /**
     * An update to the LiveBlog.
     *
     * @var BlogPosting
     */
    private $_liveBlogUpdate;

    /**
     * @return BlogPosting
     */
    public function getLiveBlogUpdate()
    {
        return $this->_liveBlogUpdate;
    }

    /**
     * @param BlogPosting $liveBlogUpdate
     * @return LiveBlogPosting|LiveBlogPostingTrait
     */
    public function setLiveBlogUpdate($liveBlogUpdate)
    {
        $this->_liveBlogUpdate = $liveBlogUpdate;
        return $this;
    }

}