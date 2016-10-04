<?php

namespace luya\cms\injectors;

use luya\cms\base\BaseBlockInjector;
use yii\db\ActiveQueryInterface;
use yii\data\ActiveDataProvider;
use luya\helpers\ArrayHelper;

/**
 * Checkboxes from an ActiveQuery.
 *
 * Generates a checkbox selection from an active query interface and returns the
 * models via the ActiveDataProvider.
 *
 * An example for the injector config:
 *
 * ```php
 * new ActiveQueryCheckboxInjector([
 *     'query' => \newsadmin\models\Article::find()->where(['cat_id' => 1]),
 * ]);
 * ```
 *
 * @property \yii\db\ActiveQueryInterface $query The ActiveQuery object
 * @since 1.0.0-rc1
 * @author Basil Suter <basil@nadar.io>
 */
class ActiveQueryCheckboxInjector extends BaseBlockInjector
{
    private $_query = null;
    
    /**
     * Setter method for the active query interface. Define the active query which will be used
     * to retrieve data.
     *
     * @param ActiveQueryInterface $query
     */
    public function setQuery(ActiveQueryInterface $query)
    {
        $this->_query = $query;
    }
    
    private function getQueryData()
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
    
    private function getExtraAssignData()
    {
        $ids = ArrayHelper::getColumn($this->getContextConfigValue($this->varName, []), 'value');
        
        $provider = new ActiveDataProvider([
            'query' => $this->_query->andWhere(['in', 'id', $ids]),
        ]);
        
        return $provider->getModels();
    }
    
    /**
     * {@inheritDoc}
     * @see \cms\base\BaseBlockInjector::setup()
     */
    public function setup()
    {
        //
        $this->setContextConfig([
            'var' => $this->varName,
            'type' => 'zaa-checkbox-array',
            'label' => $this->varLabel,
            'options' => [
                'items' => $this->getQueryData(),
            ]
        ]);
        
        $this->context->addExtraVar($this->varName, $this->getExtraAssignData());
    }
}
