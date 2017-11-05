<?php

namespace luya\cms\frontend\blockgroups;

use luya\cms\base\BlockGroup;
use luya\cms\frontend\Module;

/**
 * Main Block Group.
 *
 * This is the default group for new blocks.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
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
        return 66;
    }
}
