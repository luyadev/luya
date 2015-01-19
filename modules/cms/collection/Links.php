<?php
namespace cms\collection;

class Links extends \luya\collection\Links implements \luya\collection\LinksInterface
{

    private $langId;
    
    public function setLangId($langShortCode)
    {
        // get the langId from shortCode
        $data = \admin\models\Lang::find()->where(['short_code' => $langShortCode])->one();
        
        if (!$data) {
            throw new \Exception("The provided shortCode $langShortCode does not exists!");
        }
        $this->langId = $data->id;
    }
    
    public function start()
    {
        $this->iteration(0, '');
        foreach ($this->urls as $k => $args) {
            $this->addLink($k, $args);
        }
    }

    private $urls = [];

    private function iteration($parentNavId, $urlPrefix)
    {
        $tree = $this->getData($parentNavId);
        foreach ($tree as $index => $item) {
            if ($this->subNodeExists($item['id'])) {
                $this->iteration($item['id'], $urlPrefix.$item['rewrite'].'/');
            }
            $this->urls[$urlPrefix.$item['rewrite']] = ['url' => $urlPrefix.$item['rewrite'], 'id' => $item['id'], 'title' => $item['title']];
        }
    }

    private function getData($parentNavId)
    {
        return (new \yii\db\Query())->select(['t1.id', 't1.parent_nav_id', 't2.title', 't2.rewrite'])->from('cms_nav t1')->leftJoin("cms_nav_item t2", "t1.id=t2.nav_id")->where(['t1.parent_nav_id' => $parentNavId, 't2.lang_id' => $this->langId])->all();
    }

    private function subNodeExists($parentNavId)
    {
        return (new \yii\db\Query())->select("id")->from("cms_nav")->where(['parent_nav_id' => $parentNavId])->count();
    }
}
