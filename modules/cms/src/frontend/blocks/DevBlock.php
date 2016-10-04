<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\DevelopmentGroup;
use luya\cms\base\TwigBlock;

/**
 * Development Block in order to print data.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class DevBlock extends TwigBlock
{
    public $module = 'cms';

    public function name()
    {
        return Module::t('block_dev_name');
    }

    public function icon()
    {
        return 'developer_mode';
    }

    public function config()
    {
        return [];
    }

    public function twigFrontend()
    {
        return $this->render();
    }

    public function twigAdmin()
    {
        return '';
    }
    
    public function getBlockGroup()
    {
        return DevelopmentGroup::className();
    }
}
