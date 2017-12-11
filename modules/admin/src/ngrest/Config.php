<?php

namespace luya\admin\ngrest;

use luya\helpers\ArrayHelper;
use luya\admin\Module;
use yii\base\InvalidConfigException;
use yii\base\BaseObject;
use luya\admin\ngrest\base\NgRestRelation;

/**
 * Defines and holds an NgRest Config.
 *
 * Example config array to set via `setConfig()`.
 *
 * ```php
 * $array = [
 *     'list' => [
 *         'firstname' => [
 *             'name' => 'firstname',
 *             'alias' => 'Vorname',
 *             'i18n' => false,
 *             'extraField' => false,
 *             'type' => [
 *                 'class' => '\\admin\\ngrest\\plugins\\Text',
 *                 'args' => ['arg1' => 'arg1_value', 'arg2' => 'arg2_value']
 *             ]
 *         ]
 *     ],
 *     'create' => [
 *         //...
 *     ]
 * ];
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Config extends BaseObject implements ConfigInterface
{
    private $_config = [];
    
    /**
     * @inheritdoc
     */
    public function setConfig(array $config)
    {
        if (!empty($this->_config)) {
            throw new InvalidConfigException("Unable to override an already provided Config.");
        }
        
        $this->_config = $config;
    }
    
    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        return $this->_config;
    }
    
    private $_relations = [];
    
    /**
     * @inheritdoc
     */
    public function getRelations()
    {
        $array = [];
        
        foreach ($this->_relations as $relation) {
            /** @var $relation \luya\admin\ngrest\base\NgRestRelationInterface */
            $array[] = [
                'label' => $relation->getLabel(),
                'apiEndpoint' => $relation->getApiEndpoint(),
                'arrayIndex' => $relation->getArrayIndex(),
                'modelClass' => $relation->getModelClass(),
                'tabLabelAttribute' => $relation->getTabLabelAttribute(),
                'relationLink' => $relation->getRelationLink(),
            ];
        }
        
        return $array;
    }

    /**
     *
     * @param array $relations
     */
    public function setRelation(NgRestRelation $relation)
    {
        $this->_relations[] = $relation;
    }
    
    private $_apiEndpoint;
    
    /**
     * @inheritdoc
     */
    public function getApiEndpoint()
    {
        return $this->_apiEndpoint;
    }
    
    /**
     *
     * @param unknown $apiEndpoint
     */
    public function setApiEndpoint($apiEndpoint)
    {
        $this->_apiEndpoint = $apiEndpoint;
    }
    
    private $_attributeGroups = false;
    
    /**
     * @inheritdoc
     */
    public function getAttributeGroups()
    {
        return $this->_attributeGroups;
    }
    
    /**
     *
     * @param array $groups
     */
    public function setAttributeGroups(array $groups)
    {
        $this->_attributeGroups = $groups;
    }
    
    private $_attributeLabels = [];
    
    /**
     * @inheritdoc
     */
    public function setAttributeLabels(array $labels)
    {
        $this->_attributeLabels = $labels;
    }
    
    private $_filters = false;
    
    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return $this->_filters;
    }
    
    /**
     *
     * @param array $filters
     */
    public function setFilters(array $filters)
    {
        $this->_filters = $filters;
    }
    
    private $_defaultOrder;
    
    /**
     *
     * @return unknown
     */
    public function getDefaultOrder()
    {
        return $this->_defaultOrder;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \luya\admin\ngrest\ConfigInterface::setDefaultOrder()
     */
    public function setDefaultOrder($defaultOrder)
    {
        $this->_defaultOrder = $defaultOrder;
    }
    
    private $_groupByField;

    /**
     * @inheritdoc
     */
    public function getGroupByField()
    {
        return $this->_groupByField;
    }
    
    /**
     *
     * @param unknown $groupByField
     */
    public function setGroupByField($groupByField)
    {
        $this->_groupByField = $groupByField;
    }
    
    private $_tableName;
    
    public function getTableName()
    {
        return $this->_tableName;
    }
    
    public function setTableName($tableName)
    {
        $this->_tableName = $tableName;
    }
    
    private $_primaryKey;

    /**
     * @inheritdoc
     */
    public function getPrimaryKey()
    {
        return $this->_primaryKey;
    }
    
    /**
     *
     * @param unknown $key
     */
    public function setPrimaryKey($key)
    {
        $this->_primaryKey = $key;
    }

    /**
     * @inheritdoc
     */
    public function getDefaultOrderField()
    {
        if (!$this->getDefaultOrder()) {
            return false;
        }
        
        return key($this->getDefaultOrder());
    }
    
    /**
     * @inheritdoc
     */
    public function getDefaultOrderDirection()
    {
        if (!$this->getDefaultOrder()) {
            return false;
        }
        
        $direction = (is_array($this->getDefaultOrder())) ? current($this->getDefaultOrder()) : null; // us preg split to find in string?

        if ($direction == SORT_ASC || strtolower($direction) == 'asc') {
            return '+';
        }
            
        if ($direction == SORT_DESC || strtolower($direction) == 'desc') {
            return '-';
        }
        
        return '+';
    }

    private $_hash;
    
    /**
     * @inheritdoc
     */
    public function getHash()
    {
        if ($this->_hash === null) {
            $this->_hash = md5($this->getApiEndpoint());
        }

        return $this->_hash;
    }

    /**
     *
     * @param unknown $pointer
     * @return boolean
     */
    public function hasPointer($pointer)
    {
        return array_key_exists($pointer, $this->_config);
    }

    /**
     *
     * @param unknown $pointer
     * @param boolean $defaultValue
     * @return string
     */
    public function getPointer($pointer, $defaultValue = false)
    {
        return ($this->hasPointer($pointer)) ? $this->_config[$pointer] : $defaultValue;
    }

    /**
     *
     * @param unknown $pointer
     * @param unknown $field
     * @return boolean
     */
    public function hasField($pointer, $field)
    {
        return ($this->getPointer($pointer)) ? array_key_exists($field, $this->_config[$pointer]) : false;
    }

    /**
     *
     * @param unknown $pointer
     * @param unknown $field
     * @return boolean
     */
    public function getField($pointer, $field)
    {
        return ($this->hasField($pointer, $field)) ? $this->_config[$pointer][$field] : false;
    }

    /**
     *
     * @param unknown $pointer
     * @param array $fields
     * @return boolean[]
     */
    public function getFields($pointer, array $fields)
    {
        $data = [];
        foreach ($fields as $fieldName) {
            if ($this->getField($pointer, $fieldName)) {
                $data[$fieldName] = $this->getField($pointer, $fieldName);
            }
        }
        return $data;
    }
    
    /**
     * Get an option by its key from the options pointer. Define options like
     *
     * ```php
     * $configBuilder->options = ['saveCallback' => 'console.log(this)'];
     * ```
     *
     * Get the option parameter
     *
     * ```php
     * $config->getOption('saveCallback');
     * ```
     *
     * @param unknown $key
     * @return boolean
     */
    public function getOption($key)
    {
        return ($this->hasPointer('options') && array_key_exists($key, $this->_config['options'])) ? $this->_config['options'][$key] : false;
    }

    /**
     *
     * @param unknown $pointer
     * @param unknown $field
     * @param array $options
     * @return boolean
     */
    public function addField($pointer, $field, array $options = [])
    {
        if ($this->hasField($pointer, $field)) {
            return false;
        }

        $options = ArrayHelper::merge([
            'name' => null,
            'i18n' => false,
            'alias' => null,
            'type' => null,
            'extraField' => false,
        ], $options);

        // can not unshift non array value, create array for this pointer.
        if (empty($this->_config[$pointer])) {
            $this->_config[$pointer] = [];
        }

        $this->_config[$pointer] = ArrayHelper::arrayUnshiftAssoc($this->_config[$pointer], $field, $options);

        return true;
    }

    /**
     *
     * @param unknown $fieldName
     * @param unknown $optionKey
     * @param unknown $optionValue
     */
    public function appendFieldOption($fieldName, $optionKey, $optionValue)
    {
        foreach ($this->getConfig() as $pointer => $fields) {
            if (is_array($fields)) {
                foreach ($fields as $field) {
                    if (isset($field['name'])) {
                        if ($field['name'] == $fieldName) {
                            $this->_config[$pointer][$field['name']][$optionKey] = $optionValue;
                        }
                    }
                }
            }
        }
    }

    /**
     * Whether delete is enabled or not.
     *
     * @return boolean
     */
    public function isDeletable()
    {
        return ($this->getPointer('delete') === true) ? true : false;
    }

    private $_plugins;
    
    /**
     * Get all plugins.
     *
     * @return array
     */
    public function getPlugins()
    {
        if ($this->_plugins === null) {
            $plugins = [];
            foreach ($this->getConfig() as $pointer => $fields) {
                if (is_array($fields)) {
                    foreach ($fields as $field) {
                        if (isset($field['type'])) {
                            $fieldName = $field['name'];
                            if (!array_key_exists($fieldName, $plugins)) {
                                $plugins[$fieldName] = $field;
                            }
                        }
                    }
                }
            }
            $this->_plugins = $plugins;
        }

        return $this->_plugins;
    }

    private $_extraFields;
    
    /**
     * Get all extra fields.
     *
     * @return array
     */
    public function getExtraFields()
    {
        if ($this->_extraFields === null) {
            $extraFields = [];
            foreach ($this->getConfig() as $pointer => $fields) {
                if (is_array($fields)) {
                    foreach ($fields as $field) {
                        if (isset($field['extraField']) && $field['extraField']) {
                            if (!array_key_exists($field['name'], $extraFields)) {
                                $extraFields[] = $field['name'];
                            }
                        }
                    }
                }
            }
            $this->_extraFields = $extraFields;
        }

        return $this->_extraFields;
    }

    /**
     * @inheritdoc
     */
    public function getPointerExtraFields($pointer)
    {
        $extraFields = [];
        foreach ($this->getPointer($pointer, []) as $field) {
            if (isset($field['extraField']) && $field['extraField']) {
                $extraFields[] = $field['name'];
            }
        }
        return $extraFields;
    }

    /**
     * @inheritdoc
     */
    public function onFinish()
    {
        foreach ($this->primaryKey as $pk) {
            if (!$this->hasField('list', $pk)) {
                $alias = $pk;
                
                if (array_key_exists($alias, $this->_attributeLabels)) {
                    $alias = $this->_attributeLabels[$alias];
                } elseif (strtolower($alias) == 'id') {
                    $alias = Module::t('model_pk_id'); // use default translation for IDs if not label is given
                }
                
                $this->addField('list', $pk, [
                    'name' => $pk,
                    'alias' => $alias,
                    'type' => [
                        'class' => 'luya\admin\ngrest\plugins\Text',
                        'args' => [],
                    ],
                ]);
            }
        }
    }
}
