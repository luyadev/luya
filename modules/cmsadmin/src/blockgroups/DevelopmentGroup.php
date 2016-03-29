<?php

namespace cmsadmin\blockgroups;

use cmsadmin\base\BlockGroup;

class DevelopmentGroup extends BlockGroup
{
    public function identifier()
    {
        return 'development-group';
    }
    
    public function label()
    {
        return 'Development Elements';
    }
}