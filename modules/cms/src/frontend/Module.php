<?php

namespace luya\cms\frontend;

use Yii;
use luya\web\Application;
use luya\base\CoreModuleInterface;
use luya\web\ErrorHandler;

/**
 * Cms Module.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Module extends \luya\base\Module implements CoreModuleInterface
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
        'alias' => ['class' => 'luya\cms\tags\AliasTag'],
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
     */
    public $contentCompression= true;

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
    
    public static function onLoad()
    {
        self::registerTranslation('cms', '@cms/messages', [
            'cms' => 'cms.php',
        ]);
    }
    
    public static function t($message, array $params = [])
    {
        return parent::baseT('cms', $message, $params);
    }
}
