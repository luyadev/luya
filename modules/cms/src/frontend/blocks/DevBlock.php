<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\DevelopmentGroup;
use luya\cms\base\PhpBlock;

/**
 * Development Block in order to print data.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class DevBlock extends PhpBlock
{
    /**
     * @inheritdoc
     */
    public $module = 'cms';

    /**
     * @inheritdoc
     */
    public function blockGroup()
    {
        return DevelopmentGroup::className();
    }
    
    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_dev_name');
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'developer_mode';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '<p>' . Module::t('block_dev_name') . '</p>';
    }
    
    /**
     * @inheritdoc
     */
    public function getIsDirtyDialogEnabled()
    {
        return false;
    }
}
