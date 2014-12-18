<?php
namespace luya\collection;

interface LinksInterface
{
    public function getActiveLink();
    
    public function setActiveLink($activeLink);
    
    public function setLink($links, $args);
    
    public function getAll();
}