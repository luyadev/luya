<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Blog Posting
 *
 * A blog post.
 *
 * @see http://schema.org/BlogPosting
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
class BlogPosting extends BaseThing implements BlogPostingInterface
{
    use BlogPostingTrait;
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'BlogPosting';
    }
}
