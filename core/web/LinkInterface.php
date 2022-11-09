<?php

namespace luya\web;

/**
 * Link Resource Interface.
 *
 * Each Linkable resource object must integrate this interface in order to define the structure of a Linkable resource.
 *
 * ```php
 * <a href="<?= $object->getHref(); ?>" target="<?= $object->getTarget(); ?>">Go To</a>
 * ```
 *
 * When implementing the LinkInterface its very common to also use the {{luya\web\LinkTrait}}.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface LinkInterface
{
    /**
     * Get the href attribute value inside the Link tag.
     *
     * @return string Returns the href string which can be either with or without domain.
     */
    public function getHref();

    /**
     * Get the target attribute value inside the Link tag.
     *
     * Can be either _blank, _self.
     *
     * @return string Returns the target string value for the link resource.
     */
    public function getTarget();
}
