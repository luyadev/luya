<?php

namespace luya\traits;

trait Application
{
    public $siteTitle = 'Luya';

    public $timezone = 'Europe/Berlin';
    
    public $remoteToken = false;

    public $luyaCoreComponents = [
        'mail' => ['class' => 'luya\components\Mail'],
        'element' => ['class' => 'luya\components\Element'],
        'twig' => ['class' => 'luya\components\Twig'],
        'composition' => ['class' => 'luya\components\Composition'],  
    ];
    
    public function luyaCoreComponents()
    {
        return array_merge(parent::coreComponents(), $this->luyaCoreComponents);
    }
    
    public function getApplicationModules()
    {
        $modules = [];

        foreach ($this->getModules() as $id => $obj) {
            if ($obj instanceof \luya\base\Module && $obj->isCoreModule) {
                $modules[$id] = $obj;
            }
        }

        return $modules;
    }
}
