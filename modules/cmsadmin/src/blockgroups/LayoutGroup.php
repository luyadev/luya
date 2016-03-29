<?php

namespace cmsadmin\blockgroups;

use cmsadmin\base\BlockGroup;

class LayoutGroup extends BlockGroup
{
    public function identifier()
    {
        return 'layout-group';
    }
    
    public function label()
    {
        return 'Layout Elements';
    }
}