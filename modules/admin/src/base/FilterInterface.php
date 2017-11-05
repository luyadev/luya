<?php

namespace luya\admin\base;

/**
 * Filter Interface
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface FilterInterface
{
    /**
     * Unique identifier name for the effect, no special chars allowed.
     *
     * @return string The identifier must match [a-zA-Z0-9\-]
     */
    public static function identifier();
}
