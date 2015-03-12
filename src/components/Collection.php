<?php
namespace luya\components;

/**
 * dynamic implemention of __set and __get but what does Component already?
 *
 * @author nadar
 */
class Collection extends \yii\base\Component
{
    private $_composition;

    public function setComposition($object)
    {
        $this->_composition = $object;
    }

    public function getComposition()
    {
        return $this->_composition;
    }

    /* url */

    private $_links;

    public function setLinks($url)
    {
        $this->_links = $url;
    }

    public function getLinks()
    {
        return $this->_links;
    }
}
