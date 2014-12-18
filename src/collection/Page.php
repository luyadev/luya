<?php
namespace luya\collection;

class Page extends \luya\base\Collection
{
    private $title = null;
    
    private $content = null;
    
    /*
     const EVENT_SET_PAGE = 'SET_PAGE';
    
    public function init()
    {
    parent::init();
    $this->on(self::EVENT_SET_PAGE, [$this, 'onSet']);
    }
    
    public function onSet()
    {
    echo "JA_ON_SET";
    }
    */
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    public function getContent()
    {
        return $this->content;
    }
}