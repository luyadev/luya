<?php

namespace luya\admin\ngrest\render;

interface RenderCrudInterface
{
    public function getRelationCall();
    
    public function setRelationCall(array $options);
    
    public function getIsInline();
    
    public function setIsInline($inline);
    
    public function setModelSelection($selection);
    
    public function getModelSelection();
}
