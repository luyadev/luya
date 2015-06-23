<?php

namespace cms\collection;

class Links extends \luya\collection\Links implements \luya\collection\LinksInterface
{
    public function start()
    {
        $this->iteration(0, '', 0);
        foreach ($this->urls as $k => $args) {
            $this->addLink($k, $args);
        }
    }

    private $urls = [];

    private function iteration($parentNavId, $urlPrefix, $depth)
    {
        $tree = $this->getData($parentNavId);
        foreach ($tree as $index => $item) {
            if ($this->subNodeExists($item['id'])) {
                $this->iteration($item['id'], $urlPrefix.$item['rewrite'].'/', ($depth + 1));
            }
            $this->urls[$urlPrefix.$item['rewrite']] = [
                'url' => $urlPrefix.$item['rewrite'],
                'rewrite' => $item['rewrite'],
                'id' => (int) $item['id'],
                'parent_nav_id' => (int) $parentNavId,
                'nav_item_id' => (int) $item['nav_item_id'],
                'title' => $item['title'],
                'lang' => $item['lang_short_code'],
                'cat' => $item['cat_rewrite'],
                'depth' => (int) $depth,
            ];
        }
    }

    private function getData($parentNavId)
    {
        return \cmsadmin\models\Nav::getItemsData($parentNavId);
    }

    private function subNodeExists($parentNavId)
    {
        return (new \yii\db\Query())->select('id')->from('cms_nav')->where(['parent_nav_id' => $parentNavId])->count();
    }
}