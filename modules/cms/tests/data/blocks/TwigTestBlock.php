<?php

namespace cmstests\data\blocks;

use luya\cms\base\TwigBlock;

class TwigTestBlock extends TwigBlock
{
    public function name()
    {
        return 'PHP Test Block';
    }
    
    public function config()
    {
        return [];
    }
    
    public function twigFrontend()
    {
        return 'frontend';
    }
    
    public function twigAdmin()
    {
        return 'admin';
    }
}
