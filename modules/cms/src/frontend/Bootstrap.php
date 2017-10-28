<?php

namespace luya\cms\frontend;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\HttpException;
use luya\web\ErrorHandlerExceptionRenderEvent;
use luya\cms\models\Config;
use luya\web\Application;
use luya\web\ErrorHandler;

/**
 * CMS Bootstrap.
 *
 * The CMS bootstrap class injects the cms specific url rules
 *
 * + {{luya\cms\frontend\components\RouteBehaviorUrlRule}}
 * + {{luya\cms\frontend\components\CatchAllUrlRule}}
 *
 * And changes the behavior if an exception appears in order to redirect users to a custom cms page.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Bootstrap implements BootstrapInterface
{
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
            if ($event->exception instanceof HttpException && !YII_DEBUG) {
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
}
