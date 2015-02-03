<?php

namespace cms\controllers;

use Yii;

class DefaultController extends \luya\base\PageController
{
    public $useModuleViewPath = true;

    public $pageTitle = 'default none!';

    private $_lang = null;

    private $_context = null;

    public function init()
    {
        parent::init();
        $this->links();
        $this->_context = $this;
        $this->_lang = yii::$app->collection->lang->shortCode;
    }

    private function links()
    {
        $links = new \cms\collection\Links();
        $links->activeLink = $_GET['path'];
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
            $pageContent = $this->getPageContent($this->findDefaultPage());
            
            return $this->render('index', [
                'pageContent' => $pageContent
            ]);
            
            echo "FIND HOME! 404!";
            exit;
        }

        $parts = explode("/", $fullUrl);

        $parts[] = '__FIRST_REMOVAL'; // @todo remove

        $activeUrl = $this->findActive($urls, $parts);

        if (!$activeUrl) {
            // URL NOT FOUND! REDIRECT TO HOME
            echo "<h1>404<h1><h3>Url \"$fullUrl\" not found</h3>";
            exit;
        }

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
        // @TODO is $linkItem['id'] a unifyed system or does it only matches cause Links is set via cms\collection\Links?
        $object = \cmsadmin\models\Nav::findOne($navId);

        // @TODO Language ID
        $navItemId = $object->getItem(1)->id;

        // @TODO LANGUAGE PARAM SHOULD BE APPLYIED HERE!
        $itemType = \cmsadmin\models\NavItem::findOne($navItemId);

        $this->pageTitle = $itemType->title;

        $item = $itemType->getType();

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

        return $cat['default_nav_id'];
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
}
