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
 *     'label' => 'title', // This attribute from the model is used to render the admin block dropdown selection.
 * ]);
 * ```
 *
 * In order to configure the ActiveQueryCheckboxInjector used the {{\luya\cms\base\InternalBaseBlock::injectors}} method:
 *
 * ```php
 * public function injectors()
 * {
 *     return [
 *	       'theData' => new ActiveQueryCheckboxInjector([
 *             'query' => News::find()->where(['is_deleted' => 0]),
 *             'label' => function($model) {
 *                 return $model->title . " - " . $model->description;
 *             },
 *         ]);
 *	   ];
 * }
 * ```
 *
 * @property \yii\db\ActiveQueryInterface $query The ActiveQuery object
 * @since 1.0.0-rc1
 * @author Basil Suter <basil@nadar.io>
 */
final class ActiveQueryCheckboxInjector extends BaseBlockInjector
{
    /**
     * @var null|string|closure This attribute from the model is used to render the admin block dropdown selection. Define
     * the field name to pick for the label or set a closure lambda function in order to provide the select label template.
     *
     * ```php
     * 'label' => function($model) {
     *     return $model->title;
     * },
     * ```
     *
     * If the label attribute is not defined, just all attribute from the model will be displayed.
     */
    public $label = null;
    
    /**
     * @var boolean|array Whether the extr assigned data should enable pagination.
     */
    public $pagination = false;
    
    private $_query = null;
    
    /**
     * Setter method for the active query interface.
     *
     * Define the active query which will be used to retrieve data must be an instance of {{\yii\db\ActiveQueryInterface}}.
     *
     * @param \yii\db\ActiveQueryInterface $query The query provider for the {{yii\data\ActiveDataProvider}}.
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
            if (is_callable($this->label)) {
                $label = call_user_func($this->label, $model);
            } elseif (is_string($this->label)) {
                $label = $model->{$this->label};
            } else {
                $label = implode(", ", $model->getAttributes());
            }
            $data[] = ['value' => $model->primaryKey, 'label' => $label];
        }
        return $data;
    }
    
    private function getExtraAssignData()
    {
        $ids = ArrayHelper::getColumn($this->getContextConfigValue($this->varName, []), 'value');
        
        $provider = new ActiveDataProvider([
            'query' => $this->_query->andWhere(['in', 'id', $ids]),
            'pagination' => $this->pagination,
        ]);
        
        return $provider->getModels();
    }
    
    /**
     * @inheritdoc
     */
    public function setup()
    {
        // injecto the config
        $this->setContextConfig([
            'var' => $this->varName,
            'type' => 'zaa-checkbox-array',
            'label' => $this->varLabel,
            'options' => [
                'items' => $this->getQueryData(),
            ]
        ]);
        // provide the extra data
        $this->context->addExtraVar($this->varName, $this->getExtraAssignData());
    }
}
