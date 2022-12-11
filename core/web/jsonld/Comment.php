<?php

namespace luya\web\jsonld;

/**
 * JsonLd Comment.
 *
 * @see https://schema.org/Comment
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class Comment extends BaseThing implements CommentInterface
{
    use CommentTrait;

    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'Comment';
    }
}
