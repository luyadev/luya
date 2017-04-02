<?php

namespace luya\base;

use Yii;

/**
 * DynamicModel extends from yii\base\Dynamic Model.
 *
 * Additional Dynamic Model to provide attribute labels.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class DynamicModel extends \yii\base\DynamicModel
{
    /**
     * @var array Assignable attributes by array where key is the label key value the label for the key.
     */
    public $attributeLabels = [];
    
    /**
     * In addition to the attributeLabels() values can also be be passed by propertie and run trough Yii::t process.
     *
     * {@inheritDoc}
     *
     * @see \yii\base\Model::attributeLabels()
     * @return array
     */
    public function attributeLabels()
    {
        $labels = [];
        foreach ($this->attributeLabels as $key => $value) {
            $labels[$key] = Yii::t('app', $value);
        }
        
        return $labels;
    }
}
