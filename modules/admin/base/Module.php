<?php
namespace admin\base;

class Module extends \luya\base\Module
{
    public static $isAdmin = true;

    public $requiredComponents = ['db'];

    private $_menu = [];
    
    private $_pointers = [];
    
    public function getMenu()
    {
        return [];
    }

    protected function node($name, $icon, $template = false)
    {
        $this->_pointers['node'] = $name;
        $this->_menu[$name] = [
            'template' => $template,
            'routing' => $template ? 'custom' : 'default',
            'alias' => $name,
            'icon' => $icon,
        ];
        
        return $this;
    }
    
    protected function group($name)
    {
        $this->_pointers['group'] = $name;
        $this->_menu[$this->_pointers['node']]['groups'][$name] = ['name' => $name, 'items' => []];
        
        return $this;
    }
    
    protected function item($name, $route, $icon)
    {
        $this->_menu[$this->_pointers['node']]['groups'][$this->_pointers['group']]['items'][] = [
            'alias' => $name,
            'route' => $route,
            'icon' => $icon,
        ];   
        
        return $this;
    }
    
    protected function menu()
    {
        return $this->_menu;
    }
    
    
    public function getAuthApis()
    {
        return [];
    }
    
    public function getAuthRoutes()
    {
        return [];
    }
}
