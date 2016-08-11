<?php

namespace cmsadmin\blockgroups;

use cmsadmin\base\BlockGroup;
use cmsadmin\Module;

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
