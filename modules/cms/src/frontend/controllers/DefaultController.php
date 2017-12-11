<?php

namespace luya\cms\frontend\controllers;

use Yii;
use yii\web\View;
use yii\web\NotFoundHttpException;
use Exception;
use luya\cms\frontend\base\Controller;
use luya\helpers\StringHelper;
use luya\cms\models\Redirect;

/**
 * CMS Default Rendering
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        // enable content compression to remove whitespace
        if (!YII_DEBUG && YII_ENV_PROD && $this->module->contentCompression) {
            $this->view->on(View::EVENT_AFTER_RENDER, [$this, 'minify']);
        }
    }

    /**
     * Minify the view content.
     *
     * @param \yii\base\ViewEvent $event
     * @return string
     */
    public function minify($event)
    {
        return $event->output = $this->view->compress($event->output);
    }

    /**
     *
     * @throws NotFoundHttpException
     * @return string
     */
    public function actionIndex()
    {
        try {
            $current = Yii::$app->menu->current;
        } catch (Exception $e) {
            $path = Yii::$app->request->pathInfo;
            foreach (Redirect::find()->all() as $redirect) {
                if ($redirect->matchRequestPath($path)) {
                    return $this->redirect($redirect->getRedirectUrl(), $redirect->redirect_status_code);
                }
            }
            
            throw new NotFoundHttpException($e->getMessage());
        }

        $content = $this->renderItem($current->id, Yii::$app->menu->currentAppendix);
        
        // it is a json response (so the Response object is set to JSON_FORMAT).
        if (is_array($content)) {
            return $content;
        }
        
        return $this->renderContent($content);
    }
}
