<?php

namespace luya\admin\ngrest\base;

/**
 * NgRest Relation Interface.
 *
 * Each relation defintion must be an instance of this class.
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface NgRestRelationInterface
{
    // setter
    
    /**
     * Set the model class of the current ngRestModel.
     *
     * @param string $modelClass
     */
    public function setModelClass($modelClass);

    /**
     * Set the index of the relation in the relations array.
     *
     * @param integer $arrayIndex
     */
    public function setArrayIndex($arrayIndex);
    
    // getters
    
    /**
     * Get the encoded model class name.
     */
    public function getModelClass();
    
    /**
     * Get the array index of the relation in the relations array.
     */
    public function getArrayIndex();
    
    /**
     * Get the label of the relation.
     */
    public function getLabel();
    
    /**
     * Get the attribute name for the tab label, if nonie given the label is displayed.
     */
    public function getTabLabelAttribute();
    
    /**
     * Get relation link informations.
     */
    public function getRelationLink();
    
    /**
     * Get the api endpoint for the relation in order to make the relation data call.
     */
    public function getApiEndpoint();
}
