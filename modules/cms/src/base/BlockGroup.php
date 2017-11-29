<?php

namespace luya\cms\base;

use yii\base\BaseObject;

/**
 * Base class for all Block Groups.
 *
 * A block group contains informations about the container where a block can be grouped. This is
 * only important for the cms administration interface in order to group the blocks into containers
 * and has no affect to frontend implementations.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class BlockGroup extends BaseObject
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
