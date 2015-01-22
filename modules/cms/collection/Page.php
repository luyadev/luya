<?php
namespace cms\collection;

class Page extends \luya\collection\Page
{
    public function init()
    {
        parent::init();
        $this->find();
    }

    public function find()
    {
        $linksObject = \Yii::$app->collection->links;

        $urls = $linksObject->getAll();

        $fullUrl = $linksObject->getActiveLink();

        if (empty($fullUrl)) {
            return $this->getPageContent($this->findDefaultPage());
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
        
        
        $this->getPageContent($linkItem['id'], [
            'restString' => substr($fullUrl, strlen($linkItem['url']) + 1)       // negativPath  
        ]);
    }

    private function getPageContent($navId, $options = [])
    {
        // @TODO is $linkItem['id'] a unifyed system or does it only matches cause Links is set via cms\collection\Links?
        $object = \cmsadmin\models\Nav::findOne($navId);

        // @TODO Language ID
        $navItemId = $object->getItem(1)->id;

        // @TODO LANGUAGE PARAM SHOULD BE APPLYIED HERE!
        $itemType = \cmsadmin\models\NavItem::findOne($navItemId);

        $this->setTitle($itemType->title);

        $item = $itemType->getType();
        $item->setOptions($options);
        
        // @TODO retrieving the different content types: unify them! text not valid!
        $this->setContent($item->getContent());
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
