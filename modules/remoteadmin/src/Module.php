<?php
namespace luya\remoteadmin;

use luya\base\CoreModuleInterface;
use luya\admin\components\AdminMenuBuilder;

class Module extends \luya\admin\base\Module implements CoreModuleInterface
{
    public $apis = [
        'api-remote-site' => 'luya\remoteadmin\apis\SiteController',
    ];
    
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))->node('Remote', 'dashboard')
            ->group('Daten')
                ->itemRoute('Sites Status', 'remoteadmin/status/index', 'update')
                ->itemApi('Pages', 'remoteadmin/site/index', 'cloud', 'api-remote-site');
    }
}
