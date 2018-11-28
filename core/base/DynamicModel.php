<?php

namespace luya\base;

use Yii;

/**
 * DynamicModel extends from yii\base\Dynamic Model.
 *
 * Additional Dynamic Model to provide attribute labels and attribute hints.
 * 
 * ```php
 * $model = new DynamicModel(['query']);
 * $model->attributeLabels = ['query' => 'Search term'];
 * $model->attributeHints = ['query' => 'Enter a search term in order to find articles.'];
 * $model->addRule(['query'], 'string');
 * $model->addRule(['query'], 'required'); 
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class DynamicModel extends \yii\base\DynamicModel
{
    /**
     * @var array An array with key value pairing where key is the attribute and value the label.
     * @since 1.0.15
     */
    public $attributeHints = [];

    /**
     * @var array Assignable attributes by array where key is the label key value the label for the key.
     */
    public $attributeLabels = [];
    
    /**
     * {@inheritDoc}
     */
    public function attributeLabels()
    {
        $labels = [];
        foreach ($this->attributeLabels as $key => $value) {
            $labels[$key] = Yii::t('app', $value);
        }
        
        return $labels;
    }

    /**
     * {@inheritDoc}
     */
    public function attributeHints()
    {
        $hints = [];
        foreach ($this->attributeHints as $key => $value) {
            $hints[$key] = Yii::t('app', $value);
        }
        
        return $hints;
    }
}
