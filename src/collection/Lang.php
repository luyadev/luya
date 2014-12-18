<?php
namespace luya\collection;

class Lang extends \luya\base\Collection implements \luya\collection\LangInterface
{
    private $name;
    
    private $shortCode;
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;
    }
    
    public function getShortCode()
    {
        return $this->shortCode;
    }
    
    public function evalRequest($request)
    {
        $langId = $request->getQueryParam('langId', null);
        
        if (!is_null($langId)) {
            $this->setName($langId);
            $this->setShortCode($langId);
            return true;
        }
        
        // @TODO load default values, from where?
        $this->setName('de');
        $this->setShortCode('de');
    }
}