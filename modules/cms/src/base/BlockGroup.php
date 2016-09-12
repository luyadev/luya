<?php

namespace luya\cms\base;

use yii\base\Object;

/**
 * Base class for all Block Groups.
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class BlockGroup extends Object
{
    /**
     * The unique identifier of the block group
     *
     * @return string
     */
    abstract public function identifier();
    
    /**
     * The label used in the administration are for this group
     *
     * @return string
     */
    abstract public function label();
    
    /**
     * The position index, lower will be a the top, higher will be at the bottom of the blocks list.
     *
     * Endless Numbers are available.
     *
     * @return number The number for sort position in the administration area. 0 = Top, 100 = Bottom.
     */
    public function getPosition()
    {
        return 50;
    }
}
