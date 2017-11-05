<?php

namespace luya\admin\traits;

use luya\admin\models\Tag;

/**
 * Tag Trait.
 *
 * This trait can be assigned in order to read the tag data for an ActiveRecord model.
 *
 * See {{luya\admin\aws\TagActiveWindow}} in order to atach the TagActiveWindow.
 *
 * When the TagsTrait is attached to an {{luya\admin\ngrest\base\NgRestModel}} use the trait as below:
 *
 * ```php
 * $tags = Model::findOne(1)->tags;
 * ```
 *
 * Or you can also get all tags assigned for this table:
 *
 * ```php
 * $allTags = Model::findTags();
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
trait TagsTrait
{
    /**
     * Returns all related tag for the current active record item.
     *
     * @return \luya\admin\models\Tag An active record array from tag model.
     */
    public function getTags()
    {
        return Tag::findRelations(static::tableName(), $this->id);
    }
    
    /**
     * Get all tags associated with this table.
     *
     * @return \luya\admin\models\Tag An active record array from tag model.
     */
    public static function findTags()
    {
        return Tag::findRelationsTable(static::tableName());
    }
}
