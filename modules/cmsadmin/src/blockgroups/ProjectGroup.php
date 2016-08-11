<?php

namespace cmsadmin\blockgroups;

use cmsadmin\base\BlockGroup;
use cmsadmin\Module;

class ProjectGroup extends BlockGroup
{
    public function identifier()
    {
        return 'project-group';
    }
    
    public function label()
    {
        return Module::t('block_group_project_elements');
    }
    
    public function getPosition()
    {
        return 70;
    }
}
