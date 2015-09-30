<?php

namespace luya\traits;

trait Application
{
    public $siteTitle = 'Luya';

    public $remoteToken = false;
    
    public function getApplicationModules()
    {
        $modules = [];
        
        foreach($this->getModules() as $id => $obj) {
            if ($obj instanceof \luya\base\Module) {
                if (!$obj->isCoreModule) {
                    $modules[$id] = $obj;
                }
            }
        }
        
        return $modules;
    }
}
