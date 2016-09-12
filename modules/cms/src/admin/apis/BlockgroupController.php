<?php

namespace luya\cms\admin\apis;

/**
 * Blockgroup Api provides BlockGroup Data.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class BlockgroupController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'luya\cms\models\BlockGroup';
}
