<?php

namespace luya\cms\frontend;

use Yii;
use yii\base\BootstrapInterface;
use luya\web\Application;
use luya\base\CoreModuleInterface;
use luya\web\ErrorHandler;
use luya\web\ErrorHandlerExceptionRenderEvent;
use yii\web\HttpException;
use luya\cms\models\Config;

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
     * @var string Define an error view file who is going to be renderd when the errorAction points to the `cms/error/index` route.
     *
     * In order to handle error messages in your application configure the error handler compononent in you configuration:
     * ```php
     * 'errorHandler' => [
     *     'errorAction' => 'cms/error/index',
     * ]
     * ```
     *
     * Now configure the view file which will be rendered in your cms module:
     *
     * ```php
     * 'cms' => [
     *     'errorViewFile' => '@app/views/error/index.php',
     * ]
     * ```
     *
     * > Note that the view will be rendered with `renderPartial()`, this means the layout file will *not* be included.
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
     * @inheritdoc
     */
    public function registerComponents()
    {
        return [
            'menu' => [
                'class' => 'luya\cms\Menu',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function ($event) {
            if (!$event->sender->request->isConsoleRequest && !$event->sender->request->isAdmin) {
                $event->sender->urlManager->addRules([
                    ['class' => 'luya\cms\frontend\components\RouteBehaviorUrlRule'],
                    ['class' => 'luya\cms\frontend\components\CatchAllUrlRule'],
                ]);
            }
        });
        
        Yii::$app->errorHandler->on(ErrorHandler::EVENT_BEFORE_EXCEPTION_RENDER, function (ErrorHandlerExceptionRenderEvent $event) {
            if ($event->exception instanceof HttpException) {
                // see whether a config value exists
                // if a redirect page id exists, redirect.
                $navId = Config::get(Config::HTTP_EXCEPTION_NAV_ID, 0);
                if ($navId) {
                    $menu = Yii::$app->menu->find()->with(['hidden'])->where(['nav_id' => $navId])->one();
                    if ($menu) {
                        Yii::$app->getResponse()->redirect($menu->absoluteLink, 301)->send();
                        exit;
                    }
                }
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
