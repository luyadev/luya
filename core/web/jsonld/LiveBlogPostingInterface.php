<?php
namespace luya\web\jsonld;

/**
 * JsonLd - Live Blog Posting Interface
 *
 * @see http://schema.org/LiveBlogPosting
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
interface LiveBlogPostingInterface extends BlogPostingInterface
{
    /**
     * @return DateTime
     */
    public function getCoverageEndTime();
    /**
     * @param DateTime $coverageEndTime
     * @return LiveBlogPosting|LiveBlogPostingTrait
     */
    public function setCoverageEndTime($coverageEndTime);

    /**
     * @return DateTime
     */
    public function getCoverageStartTime();

    /**
     * @param DateTime $coverageStartTime
     * @return LiveBlogPosting|LiveBlogPostingTrait
     */
    public function setCoverageStartTime($coverageStartTime);

    /**
     * @return BlogPosting
     */
    public function getLiveBlogUpdate();

    /**
     * @param BlogPosting $liveBlogUpdate
     * @return LiveBlogPosting|LiveBlogPostingTrait
     */
    public function setLiveBlogUpdate($liveBlogUpdate);
}