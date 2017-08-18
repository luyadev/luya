<?php

namespace luya\admin\traits;

/**
 * Sortable Trait provides orderBy clause.
 *
 * By default the field `sortindex` is taken, change this by override the `sortableField` method.
 *
 * ```php
 * public static function sortableField()
 * {
 *     return 'sortfield';
 * }
 * ```
 *
 * The SortableTrait is commonly used with the {{luya\admin\ngrest\plugins\Sortable}} Plugin. By default
 * the {{luya\admin\ngrest\base\NgRestModel::ngRestListOrder}} is set to false which disables the ability
 * to sort the GRID by the end-user.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
trait SortableTrait
{
    /**
     * The field which should by used to sort.
     *
     * @return string
     */
    public static function sortableField()
    {
        return 'sortindex';
    }
    
    /**
     * Overrides the ngRestFind() method of the ActiveRecord
     * @return \yii\db\ActiveQuery
     */
    public static function ngRestFind()
    {
        return parent::ngRestFind()->orderBy([self::sortableField() => SORT_ASC]);
    }
    
    /**
     * Overrides the find() method of the ActiveRecord
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find()->orderBy([self::sortableField() => SORT_ASC]);
    }
    
    /**
     * Disable the list ordering.
     *
     * @return boolean
     */
    public function ngRestListOrder()
    {
        return false;
    }
}
