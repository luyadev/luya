<?php

namespace cmsadmin\blockgroups;

use cmsadmin\base\BlockGroup;
use cmsadmin\Module;

class TextGroup extends BlockGroup
{
    public function identifier()
    {
        return 'text-group';
    }
    
    public function label()
    {
        return Module::t('block_group_text_elements');
    }
    
    public function getPosition()
    {
        return 60;
    }
}
