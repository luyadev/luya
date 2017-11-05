<?php

namespace luya\cms\frontend\blockgroups;

use luya\cms\base\BlockGroup;
use luya\cms\frontend\Module;

/**
 * Project Block Group.
 *
 * This group belongs to all new project based blocks by default.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
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
        return 64;
    }
}
