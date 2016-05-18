<?php

namespace luya\base;

use ReflectionClass;
use yii\helpers\Inflector;

/**
 * Base Widget Class.
 * 
 * The difference to the base yii implement by changing the default view path folder.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Widget extends \yii\base\Widget
{
	/**
	 * Find view paths in application folder.
	 * 
	 * {@inheritDoc}
	 * @see \yii\base\Widget::getViewPath()
	 */
    public function getViewPath()
    {
    	// get reflection
        $class = new ReflectionClass($this);
        // get path with alias
        return '@app/views/widgets/' . Inflector::camel2id($class->getShortName());
    }
}
