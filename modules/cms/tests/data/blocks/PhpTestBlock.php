<?php

namespace cmstests\data\blocks;

use luya\cms\base\PhpBlock;

class PhpTestBlock extends PhpBlock
{
    public function name()
    {
        return 'PHP Test Block';
    }
    
    public function config()
    {
        return [];
    }
    
    public function admin()
    {
        return 'admin';
    }
    
    public function extraVars()
    {
        return ['foo' => 'bar'];
    }
}
