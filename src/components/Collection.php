<?php
namespace luya\components;

class Collection extends \yii\base\Component
{
    /* page */
    
    private $page;
    
    public function setPage(\luya\collection\CollectionAbstract $page)
    {
        //$page->trigger($page::EVENT_SET_PAGE);
        $this->page = $page;
    }
    
    public function getPage()
    {
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