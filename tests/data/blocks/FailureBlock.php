<?php

namespace tests\data\blocks;

class FailureBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';
    
    public function name()
    {
        return 'Failure Test';
    }

    public function icon()
    {
        return null;
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'var1'],
            ],
        ];
    }

    public function twigFrontend()
    {
        return null;
    }

    public function twigAdmin()
    {
        return null;
    }
}