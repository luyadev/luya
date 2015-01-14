<?php
namespace admin\base;

class Module extends \luya\base\Module
{
    public static $isAdmin = true;

    public $requiredComponents = ['db'];

    public $menu = null;

    public function getMenu()
    {
    }

    public function init()
    {
        parent::init();
        $this->menu = new \admin\components\Menu();
    }
}
