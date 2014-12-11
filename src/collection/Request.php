<?php
namespace luya\collection;

class Request extends \luya\collection\FactoryAbstract
{
    public $pathInfo = null;
    
    public function setPathInfo($pathInfo)
    {
        $this->pathInfo = $pathInfo;
    }   
    
    public function getPathInfo()
    {
        return $this->pathInfo;
    }
}