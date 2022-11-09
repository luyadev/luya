<?php

namespace luya\web\jsonld;

/**
 * JsonLd - Live Blog Posting
 *
 * A blog post intended to provide a rolling textual coverage of an ongoing event through continuous updates.
 *
 * @see http://schema.org/LiveBlogPosting
 *
 * @author Alex Schmid <alex.schmid@stud.unibas.ch>
 * @since 1.0.1
 */
class LiveBlogPosting extends BaseThing implements LiveBlogPostingInterface
{
    use LiveBlogPostingTrait;
    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'LiveBlogPosting';
    }
}
