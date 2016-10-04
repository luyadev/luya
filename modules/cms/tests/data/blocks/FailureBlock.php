<?php

namespace cmstests\data\blocks;

use luya\cms\base\TwigBlock;

class FailureBlock extends TwigBlock
{
    public $module = 'cmsadmin';

    public function name()
    {
        return 'Failure Test';
    }

    public function icon()
    {
        return;
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
        return;
    }

    public function twigAdmin()
    {
        return;
    }
}
