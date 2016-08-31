<?php

namespace luya\cms\frontend\blockgroups;

use luya\cms\base\BlockGroup;
use luya\cms\frontend\Module;

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
