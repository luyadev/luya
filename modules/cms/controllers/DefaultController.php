<?php

namespace cms\controllers;

use Yii;

class DefaultController extends \luya\base\PageController
{
    public $useModuleViewPath = true;

    public $pageTitle = 'default none!';

    public $langId = 0;
    
    private $_context = null;

    public function init()
    {
        parent::init();
        $this->links();
        $this->_context = $this;
        
        $shortCode = yii::$app->collection->composition->getKey('langShortCode');
        
        if (!$shortCode) {
            yii::$app->collection->composition->setkey('langShortCode', $this->getDefaultLangShortCode());
        }
        
        $this->langId = $this->getLangIdByShortCode(yii::$app->collection->composition->getKey('langShortCode'));
    }

    private function links()
    {
        $links = new \cms\collection\Links();
        $links->setActiveLink($_GET['path']);
        $links->start();
        yii::$app->collection->links = $links;
    }

    public function actionIndex()
    {
        $linksObject = \Yii::$app->collection->links;
        $urls = $linksObject->getAll();
        $fullUrl = $linksObject->getActiveLink();
        
        /* above collection based */

        if (empty($fullUrl)) {
            $navId = $this->findDefaultPage();
            $link = $linksObject->findOneByArguments(['id' => $navId]);
            $fullUrl = $link['url'];
            yii::$app->collection->links->setActiveLink($fullUrl);
        }
        $parts = explode("/", $fullUrl);

        $parts[] = '__FIRST_REMOVAL'; // @todo remove

        $activeUrl = $this->findActive($urls, $parts);

        if (!$activeUrl) {
            // URL NOT FOUND! REDIRECT TO HOME
            echo "<h1>404<h1><h3>Url \"$fullUrl\" not found</h3>";
            exit;
        }
        
        yii::$app->collection->links->setActiveLink($activeUrl);
        
        $linkItem = $linksObject->getLink($activeUrl);

        $pageContent = $this->getPageContent($linkItem['id'], [
            'restString' => substr($fullUrl, strlen($linkItem['url']) + 1)       // negativPath
        ]);

        return $this->render('index', [
            'pageContent' => $pageContent
        ]);
    }

    /* PRIVS */

    private function getPageContent($navId, $options = [])
    {
        $itemType = \cmsadmin\models\NavItem::find()->where(['nav_id' => $navId, 'lang_id' => $this->langId])->one();

        $this->pageTitle = $itemType->title;

        $item = $itemType->getType();

        $options['navItemId'] = $itemType->id;
        $item->setOptions($options);

        $content = $item->getContent();

        $this->setContext($item->getContext());

        return $content;
    }

    private function setContext($context)
    {
        if (empty($context)) {
            return;
        }

        foreach ($context as $prop => $value) {
            $this->$prop = $value;
        }
    }

    private function getContext()
    {
        return $this->_context;
    }

    private function findDefaultPage()
    {
        $cat = (new \yii\db\Query())->select(['id', 'default_nav_id'])->from("cms_cat")->where(['is_default' => 1])->one();

        return (int)$cat['default_nav_id'];
    }

    private function findActive($urls, $parts)
    {
        while (array_pop($parts)) {
            $match = implode("/", $parts);
            if (array_key_exists($match, $urls)) {
                return $match;
            }
        }

        return false;
    }
    
    private function getDefaultLangShortCode()
    {
        return \admin\models\Lang::find()->where(['is_default' => 1])->one()->short_code;
        
    }
    
    private function getLangIdByShortCode($shortCode)
    {
        return \admin\models\Lang::find()->where(['short_code' => $shortCode])->one()->id;
    }
}
