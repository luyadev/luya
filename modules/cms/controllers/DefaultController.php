<?php

namespace cms\controllers;

use Yii;
use yii\web\View;
use yii\web\NotFoundHttpException;

class DefaultController extends \cms\base\Controller
{
    private $_langId = null;

    public function init()
    {
        parent::init();
        // set the current path to activeUrl
        Yii::$app->links->activeUrl = (isset($_GET['path']) ? $_GET['path'] : null); // @todo should we use Yii::$app->request->get('path', null); instead?

        if (!YII_DEBUG && YII_ENV == 'prod' && $this->module->enableCompression) {
            $this->view->on(View::EVENT_AFTER_RENDER, [$this, 'minify']);
        }
    }

    public function minify($e)
    {
        return $e->output = $this->view->compress($e->output);
    }

    /**
     * find the language id based on the composition. if no lang id found, find default values and set to composition.
     */
    protected function getLangId()
    {
        if ($this->_langId === null) {
            $shortCode = Yii::$app->composition->getKey('langShortCode');

            if (!$shortCode) {
                Yii::$app->composition->setkey('langShortCode', $this->getDefaultLangShortCode());
            }

            $this->_langId = $this->getLangIdByShortCode(Yii::$app->composition->getKey('langShortCode'));
        }

        return $this->_langId;
    }

    public function actionIndex()
    {
        // get teh current active link. link component will resolve empty $activeUrl,
        $activeUrl = Yii::$app->links->getResolveActiveUrl();
        // no page found, empty default page value.
        if (!$activeUrl) {
            throw new NotFoundHttpException('The requested page could not been resolved. Missing default page?');
        }

        $suffix = Yii::$app->links->isolateLinkSuffix($activeUrl);
        $appendix = Yii::$app->links->isolateLinkAppendix($activeUrl, $suffix);

        if (!Yii::$app->links->hasLink($suffix)) {
            throw new NotFoundHttpException("The requested url '$activeUrl' does not exist.");
        }

        $link = Yii::$app->links->findOneByArguments(['lang_id' => $this->getLangId(), 'url' => $suffix]);

        if (!$link) {
            throw new NotFoundHttpException("The page '$activeUrl' does not exist in this language.");
        }

        // set the $activeUrl based on the suffix, cause the modul params are not part of the links component.
        Yii::$app->links->activeUrl = $suffix;

        return $this->render('index', [
            'pageContent' => $this->renderItem($link['id'], $appendix),
        ]);
    }

    /**
     * @todo should be static model methods inside Lang Model 
     */
    private function getDefaultLangShortCode()
    {
        return \admin\models\Lang::find()->where(['is_default' => 1])->one()->short_code;
    }

    /**
     * @todo should be static model methods inside Lang Model
     */
    private function getLangIdByShortCode($shortCode)
    {
        return \admin\models\Lang::find()->where(['short_code' => $shortCode])->one()->id;
    }
}
