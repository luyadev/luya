<?php

namespace luya\cms\frontend\controllers;

use Yii;
use yii\web\View;
use yii\web\NotFoundHttpException;
use Exception;
use luya\cms\frontend\base\Controller;

/**
 * CMS Default Rendering
 *
 * @author Basil Suter <basil@nadar.io>
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function init()
    {
        parent::init();
        // enable content compression to remove whitespace when YII_DEBUG is disabled.
        if (!YII_DEBUG && YII_ENV == 'prod' && $this->module->enableCompression) {
            $this->view->on(View::EVENT_AFTER_RENDER, [$this, 'minify']);
        }
    }

    public function minify($e)
    {
        return $e->output = $this->view->compress($e->output);
    }

    public function actionIndex()
    {
        try {
            $current = Yii::$app->menu->current;
        } catch (Exception $e) {
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
