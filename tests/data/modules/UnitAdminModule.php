<?php

namespace luyatests\data\modules;

use luya\base\Module;

class UnitAdminModule extends Module implements \luya\base\AdminModuleInterface
{
    /**
     * @var array This property is used by the {{luya\web\Bootstrap::run}} method in order to set the collected asset files to assign.
     */
    public $assets = [];

    /**
     * @var array This property is used by the {{luya\web\Bootstrap::run}} method in order to set the collected menu items forom all admin modules and build the menu.
     */
    public $moduleMenus = [];

    public function getMenu()
    {
        return [];
    }

    public function getAdminAssets()
    {
        return [];
    }

    public function getJsTranslationMessages()
    {
        return [];
    }

    public function setJsTranslations($array)
    {
        return [];
    }
}
