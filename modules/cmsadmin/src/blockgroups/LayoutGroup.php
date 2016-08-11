<?php

namespace cmsadmin\blockgroups;

use cmsadmin\base\BlockGroup;
use cmsadmin\Module;

class LayoutGroup extends BlockGroup
{
    public function identifier()
    {
        return 'layout-group';
    }
    
    public function label()
    {
        return Module::t('block_group_layout_elements');
    }
    
    public function getPosition()
    {
        return 80;
    }
}
