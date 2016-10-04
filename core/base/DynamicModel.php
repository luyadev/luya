<?php

namespace luya\base;

use Yii;

/**
 * DynamicModel extends from yii\base\Dynamic Model.
 *
 * Additional Dynamic Model to provide attribute labels.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta6
 */
class DynamicModel extends \yii\base\DynamicModel
{
    public $attributeLabels = [];
    
    public function attributeLabels()
    {
        $labels = [];
        foreach ($this->attributeLabels as $key => $value) {
            $labels[$key] = Yii::t('app', $value);
        }
        
        return $labels;
    }
}
