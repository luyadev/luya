<?php

namespace cmstests\data\blocks;

use luya\cms\base\PhpBlock;

class TestBlock extends PhpBlock
{
    public $module = 'cmsadmin';

    public function name()
    {
        return 'Test';
    }

    public function icon()
    {
        return 'test-icon';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'var1', 'label' => 'VAR 1', 'type' => 'zaa-text', 'placeholder' => 'VAR 1 PLACEHOLDER'],
                ['var' => 'var2', 'label' => 'VAR 2', 'type' => 'zaa-text'],
            ],
            'cfgs' => [
                ['var' => 'cfg1', 'label' => 'CFG 1', 'type' => 'zaa-text'],
            ],
        ];
    }

    public function admin()
    {
        return [$this->getVarValue('var1'), $this->getVarValue('var2')];
    }
}
