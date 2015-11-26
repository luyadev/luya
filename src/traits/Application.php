<?php

namespace luya\traits;

trait Application
{
    public $siteTitle = 'Luya';

    public $remoteToken = false;

    public $luyaCoreComponents = [
        'mail' => ['class' => 'luya\components\Mail'],
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

    public function getFrontendModules()
    {
        $modules = [];

        foreach ($this->getModules() as $id => $obj) {
            if ($obj instanceof \luya\base\Module && !$obj->isAdmin && strcmp($id, 'luya') != 0 && strcmp($id, 'cms') != 0) {
                $modules[$id] = $obj;
            }
        }

        return $modules;
    }
}
