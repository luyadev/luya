<?php

namespace tests\admin\components;

use admintests\AdminTestCase;
use luya\admin\components\AdminMenu;

class AdminMenuTest extends AdminTestCase
{
    /**
     *
     * @return \luya\admin\components\AdminMenu
     */
    private function getAdminMenuComponent()
    {
        return (new AdminMenu());
    }
    
    public function testGetMenu()
    {
        $menu = $this->getAdminMenuComponent()->getMenu();
     
        foreach ($menu as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('moduleId', $item);
            $this->assertArrayHasKey('template', $item);
            $this->assertArrayHasKey('routing', $item);
            $this->assertArrayHasKey('alias', $item);
            $this->assertArrayHasKey('icon', $item);
            $this->assertArrayHasKey('permissionRoute', $item);
            $this->assertArrayHasKey('permissionIsRoute', $item);
            $this->assertArrayHasKey('searchModelClass', $item);
        }
    }
    
    public function testGetNode()
    {
        $m = $this->getAdminMenuComponent();
        foreach ($m->getMenu() as $node) {
            $item = $m->getNodeData($node['id']);
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('moduleId', $item);
            $this->assertArrayHasKey('template', $item);
            $this->assertArrayHasKey('routing', $item);
            $this->assertArrayHasKey('alias', $item);
            $this->assertArrayHasKey('icon', $item);
            $this->assertArrayHasKey('permissionRoute', $item);
            $this->assertArrayHasKey('permissionIsRoute', $item);
            $this->assertArrayHasKey('searchModelClass', $item);
        }
    }
    
    public function testGetModules()
    {
        $m = $this->getAdminMenuComponent();
        
        // As currently there is no user logged in an empty array will be returned. Means no permissions
        $this->assertSame([], $m->getModules());
        
        // add tests for logged in users with permissions
        // todo
    }
    
    public function testGetModuleItems()
    {
        $m = $this->getAdminMenuComponent();
        foreach ($m->getMenu() as $node) {
            $items = $m->getModuleItems($node['id']);
            // As currently there is no user logged in an empty array will be returned. Means no permissions
            $this->assertSame([], $items);
            
            // add tests for logged in users with permissions
            // todo
        }
    }
    
    public function testGetItems()
    {
        $m = $this->getAdminMenuComponent();

        // As currently there is no user logged in an empty array will be returned. Means no permissions
        $this->assertSame([], $m->getItems());
        
        // add tests for logged in users with permissions
        // todo
    }
    
    public function testApiDetail()
    {
        $m = $this->getAdminMenuComponent();
        
        // As currently there is no user logged in an empty array will be returned. Means no permissions
        $this->assertFalse($m->getApiDetail('api-admin-user'));
        
        // add tests for logged in users with permissions
        // todo
    }
}
