<?php

namespace luya\cms\frontend\blockgroups;

use luya\cms\base\BlockGroup;
use luya\cms\frontend\Module;

class DevelopmentGroup extends BlockGroup
{
    public function identifier()
    {
        return 'development-group';
    }
    
    public function label()
    {
        return Module::t('block_group_dev_elements');
    }
    
    public function getPosition()
    {
        return 100;
    }
}
