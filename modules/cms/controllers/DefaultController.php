<?php

namespace cms\controllers;

use Yii;
use \cmsadmin\models\NavItem;
use \yii\web\NotFoundHttpException;

class DefaultController extends \cms\base\Controller
{
    private $_langId = null;
    
    public function init()
    {
        parent::init();
        // set the current path to activeLink
        Yii::$app->links->activeLink = (isset($_GET['path']) ? $_GET['path'] : null); // @todo should we use Yii::$app->request->get('path', null); instead?
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
        // get teh current active link. link component will resolve empty activeLink,
        $activeLink = Yii::$app->links->getResolveActiveLink();
        // no page found, empty default page value.
        if (!$activeLink) {
            throw new NotFoundHttpException("The requested page could not been resolved. Missing default page?");
        }
        
        $suffix = Yii::$app->links->isolateLinkSuffix($activeLink);
        $appendix = Yii::$app->links->isolateLinkAppendix($activeLink, $suffix);
        
        if (!Yii::$app->links->hasLink($suffix)) {
            throw new NotFoundHttpException("The requested link '$suffix' does not exist in the Links list.");
        }
        
        $link = Yii::$app->links->getLink($suffix);
        
        // set the activeLink based on the suffix, cause the modul params are not part of the links component.
        Yii::$app->links->activeLink = $suffix;
        
        return $this->render('index', [
            'pageContent' => $this->renderItem($link['nav_item_id'], $appendix),
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
