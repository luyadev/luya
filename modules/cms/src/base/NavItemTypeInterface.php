<?php

namespace luya\cms\base;

/**
 * Navigation Model Type Interface.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface NavItemTypeInterface
{

    /**
     * Returns the databas-nummeric identifier to make the navItem relation.
     *
     * @return integer The numeric identifier for the type (1=page, 2=module, 3=redirect, ...)
     */
    public static function getNummericType();
}
