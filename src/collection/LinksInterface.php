<?php
namespace luya\collection;

interface LinksInterface
{
    public function getActiveLink();
    
    public function setActiveLink($activeLink);
    
    public function getAll();
    
    public function setAll($links);
}