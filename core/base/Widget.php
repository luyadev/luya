<?php

namespace luya\base;

use ReflectionClass;
use yii\helpers\Inflector;

/**
 * Base Widget class using the application directory for view files.
 *
 * The difference to the base yii implement by changing the default view path folder to always lookup
 * the view files inside the application folder. This is usefull for widgets which requires to implement
 * view files and the widget only contains logic informations like a capsulated controller without views.
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
