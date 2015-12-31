<?php

namespace cms\controllers;

use Yii;
use yii\web\View;
use yii\web\NotFoundHttpException;

class DefaultController extends \cms\base\Controller
{
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

        return $this->render('index', [
            'pageContent' => $this->renderItem($current->id, Yii::$app->menu->currentAppendix),
        ]);
    }
}
