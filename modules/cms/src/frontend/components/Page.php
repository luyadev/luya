<?php

namespace luya\cms\frontend\components;

/**
 * Get page informations (actually its about properties) will be removed on rc1
 *
 * Get a property value
 *
 * ```php
 * echo Yii::$app->page->getProperty('foobar');
 * ```
 *
 * If the property has enabled `i18n = true` in the object you have to collect the active language with
 * help of the I18n helper:
 *
 * ```php
 * \admin\helpers\I18n::findCurrent(Yii::$app->page->getProperty('foobar'));
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Page extends \yii\base\Component
{
    public $model = null;
    
    private $_properties = null;
    
    private $_instances = [];

    private function getPropertyInstanceObject($name)
    {
        if (!array_key_exists($name, $this->_instances)) {
            $this->_instances[$name] = $this->model->nav->getProperty($name);
        }
        
        return $this->_instances[$name];
    }

    /**
     * Get a propertie value (by default) or defined the method to invoke from this object.
     *
     * ```php
     * ->getProperty('foobar');
     * ```
     *
     * will return false if not found and will invoke be default the `getValue()` method. You can change the
     * default value with the second paramter.
     *
     * ```php
     * ->getProperty('foobar', null);
     * ```
     *
     * will return null if not found otherwhise will invoke `getValue()` method of the property.
     *
     * ```php
     * ->getProperty('foobar', [], 'getImages');
     * ```
     *
     * will return an empty array if not found, otherwhise will invoke the `getImages()` method of this property object..
     *
     * @param string $name The defined name of the property defined in `varName()` of your property.
     * @param string $defaultValue The default value who should be returned when the property could not be found, default is `false`.
     * @param string $invokeMethod The method which should be invoked/called when the property exists, default is `getValue`.
     * @return mixed Returns the value from the `$defaultValue` if not found, otherwhise the return value from the invoken property method.
     */
    public function getProperty($name, $defaultValue = false, $invokeMethod = 'getValue')
    {
        $object = $this->getPropertyInstanceObject($name);

        if ($object) {
            return $object->$invokeMethod();
        }

        return $defaultValue;
    }
    
    public function getPropertyObject($name)
    {
        return $this->getPropertyInstanceObject($name);
    }
    
    public function getProperties()
    {
        if ($this->_properties === null) {
            $this->_properties = $this->model->nav->getProperties();
        }
        
        return $this->_properties;
    }
}
