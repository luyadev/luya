<?php

namespace luya\admin\components;

/**
 * Interface of the AdminMenuBuilder class.
 *
 * If the AdminMenuBuilder class is instance of the AdminMenuBuilderInterface we can ensure to get the menu data with `menu()` method.
 *
 * @since 1.0.0-RC2
 * @author Basil Suter <basil@nadar.io>
 */
interface AdminMenuBuilderInterface
{
    /**
     * @return array The menu array with all its nodes, subnodes routes and apis.
     */
    public function menu();
}
