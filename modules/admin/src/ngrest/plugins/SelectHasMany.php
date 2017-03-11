<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;
use luya\admin\ngrest\base\NgRestModel;

/**
 * SelectDropdown with hasMany relation (equals to `selectModel` plugin).
 * 
 * ```php
 * ngRestAttributeTypes()
 * {
 *     return [
 *         'car_id' => ['hasMany', 'relation' => 'cars],
 *     ];
 * }
 * 
 * public function getCars()
 * {
 *     return $this->hasMany(Car::class, ['car_id' => 'id']);
 * }
 * ```
 * 
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class SelectHasMany extends Select
{
	public $relation = null;
	
	public function init()
	{
		parent::init();
		
		$this->removeEvent(NgRestModel::EVENT_AFTER_FIND);
	}
	
	public function getData()
	{
		
	}
}