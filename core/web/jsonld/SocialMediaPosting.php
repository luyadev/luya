<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Social Media Posting
 *
 * A post to a social media platform, including blog posts, tweets, Facebook posts, etc.
 *
 * @see https://schema.org/SocialMediaPosting
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
class SocialMediaPosting extends BaseThing implements SocialMediaPostingInterface
{
    use SocialMediaPostingTrait;
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'SocialMediaPosting';
    }
}
