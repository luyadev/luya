<?php

namespace luya\cms\admin\apis;

use luya\admin\base\RestActiveController;

/**
 * NavItemPageBLockItem api represents the cms_nav_item_page_block_item table api.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class NavItemPageBlockItemController extends RestActiveController
{
    public $modelClass = 'luya\cms\models\NavItemPageBlockItem';
}
