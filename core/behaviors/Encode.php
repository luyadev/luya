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
 *             'class' => 'luya\behvaiors\Encode',
 *             'attributes' => [
 *                 'firstname', 'lastname', 'text',
 *             ],
 *         ],
 *     ];
 * }
 * ```
 * 
 * You can also use the {{luya\behaviors\Encode::encodeValue()}} function on the fly.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Encode extends Behavior
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
			$this->owner->{$attribute} = $this->encodeValue($this->owner->{$attribute});
		}
	}
	
	/**
	 * Encodes the given value based on {{luya\helpers\Html::encode()}}.
	 * 
	 * @param string $value The value which should be encoded.
	 * @return string Returns the encoded value.
	 */
	public function encodeValue($value)
	{
		return Html::encode($value);
	}
}