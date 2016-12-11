<?php

namespace luya\admin\helpers;

use yii\helpers\Html;
use yii\helpers\Inflector;

/**
 * Helper Method to create angular tags.
 *
 * The LUYA admin provides some default angular directives which are prefixed with `zaa`. In order to create custom
 * NgRest Plugins sometimes you may want to reuse those. There is also a helper method called `directive` which
 * allows you the quickly generate a Html Tag for directives.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta8
 */
class Angular
{

    /**
     * Internal method to use to create the angular injector helper method like in angular context of directives.js
     *
     * ```
     * "dir": "=",
     * "model": "=",
     * "options": "=",
     * "label": "@label",
     * "grid": "@grid",
     * "fieldid": "@fieldid",
     * "fieldname": "@fieldname",
     * "placeholder": "@placeholder",
     * "initvalue": "@initvalue"
     * ```
     *
     * @param string $type
     * @param string $ngModel
     * @param string $label
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     * @param array $mergeOptions Additonal attributes to be set for the tag $type.
     */
    protected static function injector($type, $ngModel, $label, $options = [], array $mergeOptions = [])
    {
        return static::directive($type, array_merge($mergeOptions, [
            'model' => $ngModel,
            'label' => $label,
            'options' => $options,
        ]));
    }

    /**
     * Create a Angular Directive tag based on the name.
     *
     * ```php
     * Angular::directive('my-input', 'name');
     * ```
     *
     * would produce the my input directive tag:
     *
     * ```html
     * <my-input ng-model="name"></my-input>
     * ```
     *
     * @param string $name The name for the generated direcitve tag which will be converted from camelcase to id notation.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function directive($name, array $options = [])
    {
        return Html::tag(Inflector::camel2id($name), null, $options);
    }
    
    /**
     * zaaSortRelationArray directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $sourceData
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaSortRelationArray($ngModel, $label, array $sourceData, array $options = [])
    {
        return self::injector('zaa-sort-relation-array', $ngModel, $label, ['sourceData' => $sourceData], $options);
    }
        
    /**
     * zaaText directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaText($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-text', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaTextarea directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaTextarea($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-textarea', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaNumber directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaNumber($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-number', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaDecimal directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaDecimal($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-decimal', $ngModel, $label, [], $options);
    }
    
    /**
     * Select directive
     *
     * ```
     * return AngularInput::zaaSelect($ngModel, $this->alias, [['value' => 123, 'label' => 123123]]);
     * ```
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $data
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaSelect($ngModel, $label, array $data, array $options = [])
    {
        return self::injector('zaa-select', $ngModel, $label, $data, $options);
    }
    
    /**
     * zaaCheckbox directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaCheckbox($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-checkbox', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaCheckboxArray directive
     *
     * ```php
     * AngularInput::zaaCheckboxArray($ngModel, $this->alias, [['value' => 123, 'label' => 123123], ['value' => 'A', 'label' => 'BCZ']]);
     * ```
     *
     * If you like to build your custom angualr directive to use two way binding without items data you can use something like tis
     *
     * ```php
     * Angular::directive('zaa-checkbox-array', $ngModel, ['options' => $this->getServiceName('myDataService')]);
     * ```
     *
     * But make sure the service you call returns the data within ['items' => $data].
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $data
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaCheckboxArray($ngModel, $label, array $data, array $options = [])
    {
        return self::injector('zaa-checkbox-array', $ngModel, $label, ['items' => $data], $options);
    }
    
    /**
     * zaaDate directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaDate($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-date', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaDatetime directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaDatetime($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-datetime', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaTable directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaTable($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-table', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaListArray directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaListArray($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-list-array', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaFileArrayUpload directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaFileArrayUpload($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-file-array-upload', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaImageArrayUpload directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaImageArrayUpload($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-image-array-upload', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaImageUpload directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaImageUpload($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-image-upload', $ngModel, $label, [], $options);
    }
    
    /**
     * zaaFileUpload directive
     *
     * @param string $ngModel The name of the ng model which should be used for data binding.
     * @param string $label The label to display for the form input.
     * @param array $options An array with optional properties for the tag creation, where key is the property name and value its content.
     */
    public static function zaaFileUpload($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-file-upload', $ngModel, $label, [], $options);
    }
}
