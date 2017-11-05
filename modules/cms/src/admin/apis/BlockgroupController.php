<?php

namespace luya\cms\admin\apis;

/**
 * Blockgroup Api provides BlockGroup Data.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class BlockgroupController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = 'luya\cms\models\BlockGroup';
}
