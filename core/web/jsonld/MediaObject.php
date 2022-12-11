<?php

namespace luya\web\jsonld;

/**
 * JsonLd MediaObject.
 *
 * @see https://schema.org/MediaObject
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class MediaObject extends BaseThing implements MediaObjectInterface
{
    use MediaObjectTrait;

    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'MediaObject';
    }
}
