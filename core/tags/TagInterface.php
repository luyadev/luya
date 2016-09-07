<?php

namespace luya\tags;

interface TagInterface
{   
    public function getReadmeMarkdown();

    public function parse($value, $sub);
    
}