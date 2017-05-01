<?php

namespace luya\admin\ngrest;

use yii\base\Object;
use luya\Exception;
use luya\helpers\ArrayHelper;
use luya\admin\Module;
use yii\base\InvalidConfigException;

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
 */
class Config extends Object implements ConfigInterface
{
    private $_config = [];
    
    public function setConfig(array $config)
    {
    	if (!empty($this->_config)) {
    		throw new InvalidConfigException("Unable to override an already provided Config.");	
    	}
    	
    	$this->_config = $config;
    }
    
    public function getConfig()
    {
    	return $this->_config;
    }
    
    private $_relations = [];
    
    public function getRelataions()
    {
    	return $this->_relations;
    }

    public function setRelations(array $relations)
    {
    	$this->_relations = $relations;
    }
    
    private $_apiEndpoint = null;
    
    public function getApiEndpoint()
    {
    	return $this->_apiEndpoint;
    }
    
    public function setApiEndpoint($apiEndpoint)
    {
    	$this->_apiEndpoint = $apiEndpoint;
    }
    
    private $_attributeGroups = false;
    
    public function getAttributeGroups()
    {
    	return $this->_attributeGroups;
    }
    
    public function setAttributeGroups(array $groups)
    {
    	$this->_attributeGroups = $groups;
    }
    
    private $_filters = false;
    
    public function getFilters()
    {
    	return $this->_filters;
    }
    
    public function setFilters(array $filters)
    {
    	$this->_filters = $filters;
    }
    
    private $_defaultOrder = null;
    
    public function getDefaultOrder()
    {
    	return $this->_defaultOrder;
    }
    
    public function setDefaultOrder($defaultOrder)
    {
    	$this->_defaultOrder = $defaultOrder;
    }
    
    private $_groupByField = null;
    
    public function getGroupByField()
    {
    	return $this->_groupByField;
    }
    
    public function setGroupByField($groupByField)
    {
    	$this->_groupByField = $groupByField;
    }
    
    private $_tableName = null;
    
    public function getTableName()
    {
    	return $this->_tableName;
    }
    
    public function setTableName($tableName)
    {
    	$this->_tableName = $tableName;
    }
    
    private $_primaryKey = null;
    
    public function getPrimaryKey()
    {
    	return $this->_primaryKey;
    }
    
    public function setPrimaryKey($key)
    {
    	$this->_primaryKey = $key;
    }
    
    public function getDefaultOrderField()
    {
        if ($this->getDefaultOrder() === null) {
            return false;
        }
        
        return key($this->getDefaultOrder());
    }
    
    public function getDefaultOrderDirection()
    {
    	if ($this->getDefaultOrder()=== null) {
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

    private $_hash = null;
    
    public function getHash()
    {
        if ($this->_hash === null) {
            $this->_hash = md5($this->getApiEndpoint());
        }

        return $this->_hash;
    }

    public function hasPointer($pointer)
    {
        return array_key_exists($pointer, $this->_config);
    }

    public function getPointer($pointer, $defaultValue = false)
    {
        return ($this->hasPointer($pointer)) ? $this->_config[$pointer] : $defaultValue;
    }

    public function hasField($pointer, $field)
    {
        return ($this->getPointer($pointer)) ? array_key_exists($field, $this->_config[$pointer]) : false;
    }

    public function getField($pointer, $field)
    {
        return ($this->hasField($pointer, $field)) ? $this->_config[$pointer][$field] : false;
    }
    
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

    public function isDeletable()
    {
        return ($this->getPointer('delete') === true) ? true : false;
    }

    private $_plugins = null;
    
    /**
     * @todo: combine getPlugins and getExtraFields()
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

    private $_extraFields = null;
    
    /**
     * @todo: combine getPlugins and getExtraFields()
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

    public function onFinish()
    {
        if (!$this->hasField('list', $this->primaryKey)) {
            $this->addField('list', $this->primaryKey, [
                'name' => $this->primaryKey,
                'alias' => Module::t('model_pk_id'),
                'type' => [
                    'class' => 'luya\admin\ngrest\plugins\Text',
                    'args' => [],
                ],
            ]);
        }
    }
}
