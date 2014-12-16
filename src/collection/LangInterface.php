<?php
namespace luya\collection;

interface LangInterface
{
    public function setName($name);
    
    public function getName();
    
    public function setShortCode($shortCode);
    
    public function getShortCode();
}