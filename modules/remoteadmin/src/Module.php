<?php
namespace luya\remoteadmin;

use luya\base\CoreModuleInterface;

class Module extends \luya\admin\base\Module implements CoreModuleInterface
{
    public $apis = [
        'api-remote-site' => 'luya\remoteadmin\apis\SiteController',
    ];
    
    public function getMenu()
    {
        return $this->node('Remote', 'dashboard')
        ->group('Daten')
        ->itemRoute('Status', 'remoteadmin/status/index', 'device_hub')
        ->itemApi('Seiten', 'remoteadmin-site-index', 'cloud', 'api-remote-site')
        ->menu();
    }
}
