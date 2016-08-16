<?php

namespace cms\injectors;


use cms\base\BaseBlockInjector;
use yii\db\ActiveQueryInterface;
use yii\data\ActiveDataProvider;

class ActiveQueryCheckbox extends BaseBlockInjector
{
    private $_query = null;
    
    public function setQuery(ActiveQueryInterface $query)
    {
        $this->_query = $query;
    }
    
    public function getQueryData()
    {
        $provider = new ActiveDataProvider([
            'query' => $this->_query,
        ]);
        
        $data = [];
        foreach ($provider->getModels() as $model) {
            $labels = [];
            foreach ($model->getAttributes() as $value) {
                if (is_string($value)) {
                    $labels[] = $value;
                }
            }
            $data[] = ['value' => $model->primaryKey, 'label' => implode(", ", $labels)];
        }
        return $data;
    }
    
    public function setup()
    {
        $this->context->addVar([
            'var' => $this->varName,
            'type' => 'zaa-checkbox-array',
            'label' => $this->varLabel,
            'options' => [
                'items' => $this->getQueryData(),
            ]
        ]);
        
        $this->context->addExtraVar($this->varName, $this->context->getVarValue($this->varName, []));
    }
}