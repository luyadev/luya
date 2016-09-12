<?php

namespace luya\cms\admin\apis;

/**
 * NavItemPageBLockItem api represents the cms_nav_item_page_block_item table api.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class NavItemPageBlockItemController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'luya\cms\models\NavItemPageBlockItem';
}
