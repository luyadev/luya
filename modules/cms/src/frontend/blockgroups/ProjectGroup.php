<?php

namespace luya\cms\frontend\blockgroups;

use luya\cms\base\BlockGroup;
use luya\cms\frontend\Module;

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
