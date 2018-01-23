<?php

use luya\web\jsonld\BaseThing;

/**
 * http://schema.org/ImageObject
 * 
 * @author nadar
 *
 */
class ImageObject extends BaseThing implements ImageObjectInterface
{
	/**
	 * @inheritdoc
 	 */
	public function typeDefintion()
	{
		return 'ImageObject';
	}
	
	use ImageObjectTrait;
}