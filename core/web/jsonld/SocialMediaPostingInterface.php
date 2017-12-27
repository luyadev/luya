<?php
namespace luya\web\jsonld;

/**
 * JsonLd - Social Media Posting Interface
 *
 * @see http://schema.org/SocialMediaPosting
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
interface SocialMediaPostingInterface extends ArticleInterface
{
    /**
     * @return CreativeWork
     */
    public function getSharedContent();

    /**
     * @param CreativeWork $sharedContent
     * @return SocialMediaPosting|SocialMediaPostingTrait
     */
    public function setSharedContent($sharedContent);
}