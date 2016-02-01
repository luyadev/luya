<?php
namespace remoteadmin;

class Module extends \admin\base\Module
{
    public $apis = [
        'api-remote-site' => 'app\modules\remoteadmin\apis\SiteController',
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
