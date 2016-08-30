<?php

namespace luya\cms\frontend\blockgroups;

use luya\cms\base\BlockGroup;
use luya\cms\frontend\Module;

class MainGroup extends BlockGroup
{
    public function identifier()
    {
        return 'main-group';
    }
    
    public function label()
    {
        return Module::t('block_group_basic_elements');
    }
    
    public function getPosition()
    {
        return 90;
    }
}
