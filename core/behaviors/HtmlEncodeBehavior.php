<?php

namespace luya\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use luya\helpers\Html;

/**
 * Auto Encodes value after find.
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'encode' => [
 *             'class' => 'luya\behaviors\HtmlEncodeBehavior',
 *             'attributes' => [
 *                 'firstname', 'lastname', 'text',
 *             ],
 *         ],
 *     ];
 * }
 * ```
 *
 * You can also use the {{luya\behaviors\HtmlEncodeBehavior::htmlEncode()}} function when behavior is
 * attached like a trait would.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.9
 */
class HtmlEncodeBehavior extends Behavior
{
    public $attributes = [];

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }
    
    /**
     * Event will be triggered after find.
     *
     * @param \yii\base\Event $event The after find event.
     */
    public function afterFind($event)
    {
        foreach ($this->attributes as $attribute) {
            $this->owner->{$attribute} = $this->htmlEncode($this->owner->{$attribute});
        }
    }
    
    /**
     * Encodes the given value based on {{luya\helpers\Html::encode()}}.
     *
     * @param string $value The value which should be encoded.
     * @return string Returns the encoded value.
     */
    public function htmlEncode($value)
    {
        return Html::encode($value);
    }
}
