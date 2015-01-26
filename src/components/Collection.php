<?php
namespace luya\components;

/**
 * dynamic implemention of __set and __get but what does Component already?
 * @author nadar
 *
 */
class Collection extends \yii\base\Component
{
    /* page */

    private $page;

    public function setPage(\luya\collection\Page $page)
    {
        //$page->trigger($page::EVENT_SET_PAGE);
        if (!empty($this->page)) {
            $page->setPrevObject($this->page);
        }
        $this->page = $page;
    }

    public function getPage()
    {
        if (($pref = $this->page->getPrevObject()) !== false) {
            return $this->page->getPrevObject();
        }

        return $this->page;
    }

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
