<?php

namespace luya\admin\ngrest\plugins;

use Yii;
use luya\admin\ngrest\base\Plugin;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;
use luya\admin\ngrest\NgRest;

/**
 * Checkbox Realtion based on an ActiveRelation.
 *
 * This plugin uses the the active linking abilieits of the yii relations.
 *
 * Example implementation:
 *
 * ```php
 * public $adminGroups = [];
 *
 * public function ngRestExtraAttributeTypes()
 * {
 *     return [
 *         'adminGroups' => [
 *             'class' => CheckboxRelationActiveQuery::class,
 *             'query' => $this->getGroups(),
 *             'labelField' => ['name'],
 *         ],
 *    ];
 * }
 *
 * public function extraFields()
 * {
 *     return ['adminGroups'];
 * }
 *
 * public function getGroups()
 * {
 *     return $this->hasMany(Group::class, ['id' => 'group_id'])->viaTable(ProductGroupRef::tableName(), ['product_id' => 'id']);
 * }
 * ```
 *
 * @property \yii\db\ActiveQuery $query Active Query relation.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class CheckboxRelationActiveQuery extends CheckboxRelation
{
    public $onlyRestScenarios = true;
    
    /**
     *
     * {@inheritDoc}
     * @see \luya\admin\ngrest\plugins\CheckboxRelation::init()
     */
    public function init()
    {
        parent::init();
        
        if ($this->query === null) {
            throw new InvalidConfigException("The query propertie can not be null and must be set.");
        }
        
        $this->model = $this->query->modelClass;
        $this->refJoinTable = $this->query->via->from[0];
        // find link between reference field and joining table model $model
        foreach ($this->query->via->link as $base => $on) {
            $this->refModelPkId = $base;
        }
        // find link between reference field and primary model
        foreach ($this->query->link as $base=> $on) {
            $this->refJoinPkId = $on;
        }
    }
    
    private $_query = null;
    
    /**
     * Setter method for ActiveQuery.
     *
     * @param ActiveQuery $query
     */
    public function setQuery(ActiveQuery $query)
    {
        $this->_query = $query;
    }
    
    /**
     * Getter method for ActiveQuery.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        return $this->_query;
    }
}
