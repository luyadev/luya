<?php

namespace luya\admin\ngrest;

/**
 * NgRest Config Interface
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface ConfigInterface
{
    public function setConfig(array $config);

    public function getConfig();

    public function getExtraFields();

    public function onFinish();
    
    // ensured
    
    public function getHash();
    
    public function getPrimaryKey();
    
    public function setDefaultOrder($defaultOrder);
    
    public function getDefaultOrderDirection();
    
    public function getDefaultOrderField();

    public function getTableName();
    
    public function getOption($key);

    public function getGroupByField();
    
    public function getFilters();
    
    public function getAttributeGroups();
    
    public function getApiEndpoint();

    public function getRelations();
    
    public function setAttributeLabels(array $labels);
}
