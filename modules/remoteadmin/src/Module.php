<?php
namespace luya\remoteadmin;

use Yii;
use luya\base\CoreModuleInterface;
use luya\admin\components\AdminMenuBuilder;

/**
 * 
 * @author Basil Suter <basil@nadar.io>
 *
 */
class Module extends \luya\admin\base\Module implements CoreModuleInterface
{
    public $apis = [
        'api-remote-site' => 'luya\remoteadmin\apis\SiteController',
    ];
    
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))->node('Remote', 'dashboard')
            ->group('Daten')
                ->itemRoute('Status', 'remoteadmin/status/index', 'update')
                ->itemApi('Pages', 'remoteadmin/site/index', 'cloud', 'api-remote-site');
    }
    
    /**
     * @var array Registering translation files for the admin module.
     */
    public $translations = [
        [
            'prefix' => 'remoteadmin*',
            'basePath' => '@remoteadmin/messages',
            'fileMap' => [
                'admin' => 'remoteadmin.php',
            ],
        ],
    ];
    
    /**
     * Remoteadmin
     *
     * @param string $message The message key to translation
     * @param array $params Optional parameters to pass to the translation.
     * @return string The translated message.
     */
    public static function t($message, array $params = [])
    {
        return Yii::t('remoteadmin', $message, $params);
    }
}
