<?php

namespace cms\menu;

use Yii;

class Item extends \yii\base\Object
{
    public $itemArray = [];

    private $_with = [];

    public function getId()
    {
        return $this->itemArray['id'];
    }

    public function getNavId()
    {
        return $this->itemArray['nav_id'];
    }

    public function getParentNavId()
    {
        return $this->itemArray['parent_nav_id'];
    }

    public function getTitle()
    {
        return $this->itemArray['title'];
    }

    public function getAlias()
    {
        return $this->itemArray['alias'];
    }

    public function getLink()
    {
        return ($this->itemArray['is_home'] && Yii::$app->composition->defaultLangShortCode == $this->itemArray['lang']) ? Yii::$app->urlManager->baseUrl : $this->itemArray['link'];
    }

    public function getIsActive()
    {
        return array_key_exists($this->id, Yii::$app->menu->current->teardown);
    }

    public function getDepth()
    {
        return $this->itemArray['depth'];
    }

    public function getParent()
    {
        return (new Query())->where(['nav_id' => $this->parentNavId])->with($this->_with)->one();
    }

    /**
     * Return all parent elements (breadcrumb behavior) without the current item.
     *
     * @return array
     */
    public function getParents()
    {
        $parent = $this->getParent();
        $data = [];
        while ($parent) {
            $data[] = $parent;
            $parent = $parent->getParent();
        }

        return array_reverse($data);
    }

    /**
     * same as getParents but includes the current node too.
     */
    public function getTeardown()
    {
        $parent = $this->getParent();
        $current = $this;
        $data[$current->id] = $current;
        while ($parent) {
            $data[$parent->id] = $parent;
            $parent = $parent->getParent();
        }

        return array_reverse($data, true);
    }

    public function getChildren()
    {
        return (new Query())->where(['parent_nav_id' => $this->navId])->with($this->_with)->all();
    }

    public function hasChildren()
    {
        return ((new Query())->where(['parent_nav_id' => $this->navId])->with($this->_with)->one()) ? true : false;
    }

    /**
     * @see \cms\menu\Query::with()
     */
    public function with($with)
    {
        $this->_with = (array) $with;

        return $this;
    }
}
