<?php

namespace luya\base;

/**
 * Mark a module as Admin Module.
 *
 * All administration modules must implement the AdminModuleInterface, this allows LUYA to
 * deliver modules on the area the are used. Some modules are only used in frontend others
 * are just in administration context those modules must implement `AdminModuleInterface`.
 *
 * @since 1.0.0-RC1
 * @author Basil Suter <basil@nadar.io>
 */
interface AdminModuleInterface
{
    /**
     * The menu object from the {{\luya\admin\components\AdminMenuBuilder}} class in order to store and build the administration
     * module menu elements.
     * 
     * @return array|\luya\admin\components\AdminMenuBuilderInterface
     */
    public function getMenu();
}
