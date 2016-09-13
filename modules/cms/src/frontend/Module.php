<?php

namespace luya\cms\frontend;

use Yii;
use yii\base\BootstrapInterface;
use luya\web\Application;
use luya\base\CoreModuleInterface;

/**
 * Cms Module.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Module extends \luya\base\Module implements BootstrapInterface, CoreModuleInterface
{
    /**
     * @var array We have no urlRules in cms Module. the UrlRoute file will only be used when
     * no module is provided. So the CMS url alias does only apply on default behavior.
     */
    public $urlRules = [
        ['pattern' => 'preview/<itemId:\d+>', 'route' => 'cms/preview/index'],
        ['pattern' => 'block-ajax/<id:\d+>/<callback:[a-z0-9\-]+>', 'route' => 'cms/block/index'],
    ];

    public $tags = [
        'menu' => ['class' => 'luya\cms\tags\MenuTag'],
        'page' => ['class' => 'luya\cms\tags\PageTag'],
    ];
    
    /**
     * @var string To handle error messages in your application put `'errorHandler' => ['errorAction' => 'cms/error/index']` in config file.
     * To replace the standard error view file with your own - configure via the cms module in your config: `'cms' => ['errorViewFile' => '@app/views/error/index.php']`
     * Please note that you'll have to define the layout in the view as it's rendered via `renderPartial()`.
     */
    public $errorViewFile = "@cms/views/error/index.php";

    /**
     * @var bool If enabled the cms content will be compressed (removing of whitespaces and tabs).
     * @todo rename to $contentCompression (as enable is expressed by the boolean value)
     */
    public $enableCompression = true;

    /**
     * @var boolean Whether the overlay toolbar of the CMS should be enabled or disabled.
     */
    public $overlayToolbar = true;
    
    /**
     * @var bool If enableTagParsing is enabled tags like `link(1)` or `link(1)[Foo Bar]` will be parsed
     * and transformed into links based on the cms.
     */
    public $enableTagParsing = true;
    
    /**
     *
     * {@inheritDoc}
     * @see \luya\base\Module::registerComponents()
     */
    public function registerComponents()
    {
        return [
            'menu' => [
                'class' => 'luya\cms\Menu',
            ],
        ];
    }

    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function ($event) {
            if (!$event->sender->request->isConsoleRequest && !$event->sender->request->isAdmin()) {
                $event->sender->urlManager->addRules([
                    ['class' => 'luya\cms\frontend\components\RouteBehaviorUrlRule'],
                    ['class' => 'luya\cms\frontend\components\CatchAllUrlRule'],
                ]);
            }
        });
    }
    
    public $translations = [
        [
            'prefix' => 'cms',
            'basePath' => '@cms/messages',
            'fileMap' => [
                'cms' => 'cms.php',
            ],
        ],
    ];
    
    public static function t($message, array $params = [])
    {
        return Yii::t('cms', $message, $params, Yii::$app->luyaLanguage);
    }
}
