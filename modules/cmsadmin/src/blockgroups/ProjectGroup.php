<?php

namespace cmsadmin\blockgroups;

use cmsadmin\base\BlockGroup;

class ProjectGroup extends BlockGroup
{
    public function identifier()
    {
        return 'project-group';
    }
    
    public function label()
    {
        return 'Project Elements';
    }
}