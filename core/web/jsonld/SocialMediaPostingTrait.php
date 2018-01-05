<?php
namespace luya\web\jsonld;

/**
 * JsonLd - Social Media Posting trait
 *
 * @see http://schema.org/SocialMediaPosting
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
trait SocialMediaPostingTrait
{
    use ArticleTrait;

    private $_sharedContent;

    /**
     * @return CreativeWork
     */
    public function getSharedContent()
    {
        return $this->_sharedContent;
    }

    /**
     * A CreativeWork such as an image, video, or audio clip shared as part of this posting.
     *
     * @param CreativeWork $sharedContent
     * @return SocialMediaPosting|SocialMediaPostingTrait
     */
    public function setSharedContent($sharedContent)
    {
        $this->_sharedContent = $sharedContent;
        return $this;
    }
}
