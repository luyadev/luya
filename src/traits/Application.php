<?php

namespace luya\traits;

trait Application
{
    /**
     * @var string Title for the appliation used in differnt sections like Login screen
     */
    public $siteTitle = 'Luya';

    /**
     * @var string The internal used language to translate luya message, this is also used for all luya
     * core modules. Currently available languages
     * + en
     * + de
     *
     * @since 1.0.0-beta2
     */
    public $luyaLanguage = 'en';
    
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

    /**
     * Return a list with all registrated frontend modules except 'luya' and 'cms'. This is needed in the module block.
     *
     * @return array
     */
    public function getFrontendModules()
    {
        $modules = [];

        foreach ($this->getModules() as $id => $obj) {
            if ($obj instanceof \luya\base\Module && !$obj->isAdmin && $id !== 'luya' && $id !== 'cms') {
                $modules[$id] = $obj;
            }
        }

        return $modules;
    }
}
