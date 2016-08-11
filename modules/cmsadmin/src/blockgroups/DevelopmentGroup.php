<?php

namespace cmsadmin\blockgroups;

use cmsadmin\base\BlockGroup;
use cmsadmin\Module;

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
