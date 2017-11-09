<?php
namespace luya\remoteadmin;

use Yii;
use luya\base\CoreModuleInterface;
use luya\admin\components\AdminMenuBuilder;

/**
 * Remote Module.
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Module extends \luya\admin\base\Module implements CoreModuleInterface
{
    public $apis = [
        'api-remote-site' => 'luya\remoteadmin\apis\SiteController',
    ];
    
    public function getMenu()
    {
        return (new AdminMenuBuilder($this))->node('Remote', 'settings_remote')
            ->group('Daten')
                ->itemRoute('Status', 'remoteadmin/status/index', 'update')
                ->itemApi('Pages', 'remoteadmin/site/index', 'cloud', 'api-remote-site');
    }
    public static function onLoad()
    {
        self::registerTranslation('remoteadmin', '@remoteadmin/messages', [
            'remoteadmin' => 'remoteadmin.php',
        ]);
    }
    
    /**
     * Remoteadmin
     *
     * @param string $message The message key to translation
     * @param array $params Optional parameters to pass to the translation.
     * @return string The translated message.
     */
    public static function t($message, array $params = [])
    {
        return parent::baseT('remoteadmin', $message, $params);
    }
}
