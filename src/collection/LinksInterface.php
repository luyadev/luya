<?php
namespace luya\collection;

interface LinksInterface
{
    public function getActiveLink();

    public function setActiveLink($activeLink);

    public function addLink($link, $args);

    public function getAll();

    public function getByArguments(array $argsArray);
    
    public function getOneByArguments(array $argsArray);
    
    public function teardown($link);
    
    public function getParents($link);
    
    public function getParent($link);
    
    public function getChilds($link);
    
    public function getChild($link);
}
