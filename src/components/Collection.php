<?php
namespace luya\components;

/**
 * dynamic implemention of __set and __get but what does Component already?
 * @author nadar
 *
 */
class Collection extends \yii\base\Component
{
    /* lang */

    private $lang;

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function getLang()
    {
        return $this->lang;
    }

    /* url */

    private $links;

    public function setLinks($url)
    {
        $this->links = $url;
    }

    public function getLinks()
    {
        return $this->links;
    }
}
