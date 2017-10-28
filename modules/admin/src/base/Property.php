<?php

namespace luya\admin\base;

use luya\admin\helpers\I18n;
use yii\base\Component;

/**
 * Abstract Page Property Class.
 *
 * Each property must implement this class.
 *
 * Reade more in the Guide [[app-cmsproperties.md]].
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Property extends Component implements TypesInterface
{
    /**
     * @var string The name of the event will be triggered before rendering
     */
    const EVENT_BEFORE_RENDER = 'EVENT_BEFORE_RENDER';

    /**
     * @var string The module where the property is located.
     */
    public $moduleName;

    /**
     * @var mixed The value from the database assigned into the property object.
     */
    public $value;
    
    /**
     * @var boolean Whether the property is used for an i18n use case or not, this will
     * serialize the input as json into the database and the getValue/getAdminValue methods will
     * automatically unserialize the correctly value.
     */
    public $i18n = false;

    /**
     * The internal variable name for this property.
     *
     * This is like a variable name identifer, this should be unique value across all properties. Allowed
     * chars are `a-zA-Z0-9-_`. The defined variable named will be use when retrieving data from a property
     * in the frontend. For example `Yii::$app->menu->current->getProperty('varName`)` where varName is the
     * varaiable name you choosen as return value of this method.
     *
     * Example:
     *
     * ```php
     * public function varName()
     * {
     *     return 'myVariable';
     * }
     * ```
     *
     * @return string
     */
    abstract public function varName();

    /**
     * The label which is displayed in the administration area.
     *
     * Example:
     *
     * ```php
     * public function label()
     * {
     *     return 'My Variable';
     * }
     * ```
     *
     * @return string
     */
    abstract public function label();

    /**
     * The specifation of what type this property is.
     *
     * There are different types of variables/propertys to create. Sometimes its
     * just a plain text field, textarea or and image or multip image upload. Therefore
     * the method `type()` defines what should be created. All types are available als
     * constants inside the {{\luya\admin\base\TypesInterface}}.
     *
     * Example:
     *
     * ```php
     * public function type()
     * {
     *     return self::TYPE_SELECT;
     * }
     * ```
     *
     * @see \luya\admin\base\TypesInterface
     * @return string
     */
    abstract public function type();

    /**
     * When the object is force to return as string the `getValue()` method is returned.
     *
     * @return mixed
     */
    public function __toString()
    {
        return empty($this->getValue()) ? '' : $this->getValue();
    }
    
    /**
     * Options you may have to pass to the selected type.
     *
     * Sometimes the type of property requires more informations and optional data
     * those datas needs to be returned. Example of options to return when using
     * the TYPE_SELECT property type:
     *
     * ```php
     * public function options()
     * {
     *     return [
     *         ['value' => 'ul', 'label' => 'Pointed List'],
     *         ['value' => 'ol', 'label' => 'Nummeic List'],
     *     ];
     * }
     * ```
     *
     * @return mixed
     */
    public function options()
    {
        return [];
    }

    /**
     * If the property is requested in admin context and there is no value
     * the `default()` value response will be used.
     *
     * For example a preselecting item from a list select dropdown:
     *
     * ```php
     * public function defaultValue()
     * {
     *     return 'default';
     * }
     * ```
     *
     * @return mixed
     */
    public function defaultValue()
    {
        return false;
    }
    
    /**
     * The value is passed from the administration area side to the angular view.
     *
     * @return mixed
     */
    public function getAdminValue()
    {
        if ($this->i18n) {
            $this->value = I18n::decode($this->value);
        }
        
        return $this->value;
    }
    
    /**
     * This is what will be returned when the property is requested in the frontend.
     *
     * You can override this function in order to provide your own output logic.
     *
     * Make sure to call the parent implementation of getValue when overriding this function in
     * order to make sure the usage of i18n variables:
     *
     * ```php
     * public function getValue()
     * {
     *     $value = parent::getValue();
     *     // do something with value and return
     *     return Yii::$app->storage->getImage($value);
     * }
     * ```
     *
     * @return mixed The value stored in the database for this property.
     */
    public function getValue()
    {
        if ($this->i18n) {
            $this->value = I18n::decode($this->value);
        }
        
        return $this->value;
    }
}
