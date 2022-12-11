<?php

namespace luya\web\jsonld;

/**
 * JsonLd ImageObject.
 *
 * @see https://schema.org/ImageObject
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class ImageObject extends BaseThing implements ImageObjectInterface
{
    use ImageObjectTrait;

    /**
     * @inheritdoc
     */
    public function typeDefintion()
    {
        return 'ImageObject';
    }
}
