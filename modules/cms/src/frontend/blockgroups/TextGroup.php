<?php

namespace luya\cms\frontend\blockgroups;

use luya\cms\base\BlockGroup;
use luya\cms\frontend\Module;

/**
 * Text Block Group.
 *
 * This group belongs to all basic text elements.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
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
