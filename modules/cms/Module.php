<?php

namespace cms;

class Module extends \luya\base\Module
{
    /**
     * We have no urlRules in cms Module. the UrlRoute file will only be used when
     * no module is provided. So the CMS url rewrites does only apply on default behavior.
     */
    public $urlRules = [];
    
    public function registerComponents()
    {
        return [
            'links' => [
                'class' => 'cms\components\Links'
            ]  
        ];
    }
}
