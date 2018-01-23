<?php

use luya\web\jsonld\BaseThing;

/**
 * http://schema.org/PropertyValue
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.3
 */
class PropertyValue extends BaseThing
{
	/**
	 * @inheritdoc
	 */
	public function typeDefintion()
	{
		return 'PropertyValue';
	}
	
	use PropertyValueTrait;
}