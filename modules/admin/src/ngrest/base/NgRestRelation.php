<?php

namespace luya\admin\ngrest\base;

use yii\base\BaseObject;
use yii\db\QueryInterface;
use yii\data\ActiveDataProvider;

/**
 * NgRest Relation Defintion.
 *
 * An NgRest Relation defined which is used by {{luya\admin\ngrest\base\NgRestModel::ngRestRelations()}} array.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class NgRestRelation extends BaseObject implements NgRestRelationInterface
{
    private $_modelClass;
    
    /**
     * @inheritdoc
     */
    public function setModelClass($modelClass)
    {
        $this->_modelClass = base64_encode($modelClass);
    }
    
    /**
     * @inheritdoc
     */
    public function getModelClass()
    {
        return $this->_modelClass;
    }
    
    private $_apiEndpoint;
    
    /**
     *
     * @param string $apiEndpoint
     */
    public function setApiEndpoint($apiEndpoint)
    {
        $this->_apiEndpoint = $apiEndpoint;
    }
    
    /**
     * @inheritdoc
     */
    public function getApiEndpoint()
    {
        return $this->_apiEndpoint;
    }

    private $_relationLink;
    
    /**
     *
     * @param string $relationLink
     */
    public function setRelationLink($relationLink)
    {
        $this->_relationLink = $relationLink;
    }
    
    /**
     * @inheritdoc
     */
    public function getRelationLink()
    {
        if ($this->_relationLink === null) {
            // determine relation link from dataProvider
            if ($this->getDataProvider() instanceof ActiveDataProvider) {
                $this->_relationLink = $this->getDataProvider()->link;
            }
        }
        
        return $this->_relationLink;
    }

    private $_tabLabelAttribute;
    
    /**
     *
     * @param string $attribute
     */
    public function setTabLabelAttribute($attribute)
    {
        $this->_tabLabelAttribute = $attribute;
    }
    
    /**
     * @inheritdoc
     */
    public function getTabLabelAttribute()
    {
        return $this->_tabLabelAttribute;
    }
    
    private $_dataProvider;
    
    /**
     *
     * @param QueryInterface $query
     */
    public function setDataProvider(QueryInterface $query)
    {
        $this->_dataProvider = $query;
    }
    
    /**
     * @inheritdoc
     */
    public function getDataProvider()
    {
        return $this->_dataProvider;
    }
    
    private $_label;

    /**
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->_label = $label;
    }
    
    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return $this->_label;
    }
    
    private $_arrayIndex;
    
    /**
     * @inheritdoc
     */
    public function setArrayIndex($index)
    {
        $this->_arrayIndex = $index;
    }
    
    /**
     * @inheritdoc
     */
    public function getArrayIndex()
    {
        return $this->_arrayIndex;
    }
}
