<?php

namespace luya\web;

use Yii;
use luya\traits\ApplicationTrait;
use yii\web\ForbiddenHttpException;

/**
 * LUYA Web Application.
 *
 * @property \luya\cms\Menu $menu Menu component in order to build navigation from CMS module.
 * @property \luya\admin\storage\BaseFileSystemStorage $storage Storage component for reading, saving and holding files from the Admin module.
 * @property \luya\web\Composition $composition Composition component.
 * @property \luya\web\Element $element The element component.
 * @property \luya\web\View $view The view component.
 * @property \luya\web\Request $request The request component.
 * @property \luya\web\ErrorHandler $errorHandler The error handler component.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Application extends \yii\web\Application
{
    use ApplicationTrait;

    /**
     * @inheritdoc
     */
    public function handleRequest($request)
    {
        if ($this->ensureSecureConnection && !$request->isSecureConnection) {
            throw new ForbiddenHttpException("Insecure connection is not allowed.");
        }
        
        if ($this->ensureSecureConnection) {
            // add secure flag to cookie
            Yii::$app->request->csrfCookie = ['httpOnly' => true, 'secure' => true];
            Yii::$app->session->cookieParams = ['httpOnly' => true, 'secure' => true];
            // apply strict, hsts and x-* headers
            Yii::$app->response->headers->set('Strict-Transport-Security', 'max-age=31536000');
            Yii::$app->response->headers->set('X-XSS-Protection', "1; mode=block");
            Yii::$app->response->headers->set('X-Frame-Options', "SAMEORIGIN");
            Yii::$app->response->headers->set('Content-Security-Policy', "default-src https:");
        }
        
        return parent::handleRequest($request);
    }
    
    /**
     * @inheritdoc
     */
    public function coreComponents()
    {
        return array_merge($this->luyaCoreComponents(), [
            'request' => ['class' => 'luya\web\Request'],
            'errorHandler' => ['class' => 'luya\web\ErrorHandler'],
            'urlManager' => ['class' => 'luya\web\UrlManager'],
            'view' => ['class' => 'luya\web\View'],
            'element' => ['class' => 'luya\web\Element'],
            'composition' => ['class' => 'luya\web\Composition'],
            'assetManager' => [
                'class' => 'luya\web\AssetManager',
                'forceCopy' => YII_DEBUG,
                'appendTimestamp' => !YII_DEBUG,
            ],
        ]);
    }
}
