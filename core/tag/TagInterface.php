<?php

namespace luya\tag;

interface TagInterface
{   
    public function readme();

    public function parse($value, $sub);
    
}