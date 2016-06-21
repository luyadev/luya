<?php

namespace admin\helpers;

use yii\helpers\Html;

/**
 * Helper Method to create admin angular directive inputs
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta8
 */
class AngularInput
{

    /**
     * "dir": "=",
     * "model": "=",
     * "options": "=",
     * "label": "@label",
     * "grid": "@grid",
     * "fieldid": "@fieldid",
     * "fieldname": "@fieldname",
     * "placeholder": "@placeholder",
     * "initvalue": "@initvalue"
     */
    protected static function injector($type, $ngModel, $label, $options = [], array $mergeOptions = [])
    {
        return Html::tag($type, null, array_merge($mergeOptions, [
            'model' => $ngModel,
            'label' => $label,
            'options' => $options,
        ]));
    }
    
    public static function zaaSortRelationArray($ngModel, $label, array $sourceData, array $options = [])
    {
        return self::injector('zaa-sort-relation-array', $ngModel, $label, ['sourceData' => $sourceData], $options);
    }
        
    public static function zaaText($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-text', $ngModel, $label, [], $options);
    }
    
    public static function zaaTextarea($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-textarea', $ngModel, $label, [], $options);
    }
    
    public static function zaaNumber($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-number', $ngModel, $label, [], $options);
    }
    
    public static function zaaDecimal($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-decimal', $ngModel, $label, [], $options);
    }
    
    /**
     * Select Option
     * 
     * ```
     * return AngularInput::zaaSelect($ngModel, $this->alias, [['value' => 123, 'label' => 123123]]);
     * ```
     * 
     * @param unknown $ngModel
     * @param unknown $label
     * @param array $data
     * @param array $options
     */
    public static function zaaSelect($ngModel, $label, array $data, array $options = [])
    {
        return self::injector('zaa-select', $ngModel, $label, $data, $options);
    }
    
    public static function zaaCheckbox($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-checkbox', $ngModel, $label, [], $options);
    }
    
    /**
     * Checkbox Array
     * 
     * ```
     * AngularInput::zaaCheckboxArray($ngModel, $this->alias, [['value' => 123, 'label' => 123123], ['value' => 'A', 'label' => 'BCZ']]);
     * ```
     * 
     * @param unknown $ngModel
     * @param unknown $label
     * @param array $data
     * @param array $options
     */
    public static function zaaCheckboxArray($ngModel, $label, array $data, array $options = [])
    {
        return self::injector('zaa-checkbox-array', $ngModel, $label, ['items' => $data], $options);
    }
    
    public static function zaaDate($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-date', $ngModel, $label, [], $options);
    }
    
    public static function zaaDatetime($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-datetime', $ngModel, $label, [], $options);
    }
    
    public static function zaaTable($ngModel, $label, array $options = [])
    {
        return self::injector('zaa-table', $ngModel, $label, [], $options);
    }
    
    public static function zaaListArray($ngModel, $label, array $options = [])
    {
        //return self::injector('zaa-table', $ngModel, $label, [], $options);
    }
    
    public static function zaaFileArrayUpload($ngModel, $label, array $options = [])
    {
        //return self::injector('zaa-table', $ngModel, $label, [], $options);
    }
    
    public static function zaaImageArrayUpload($ngModel, $label, array $options = [])
    {
        //return self::injector('zaa-table', $ngModel, $label, [], $options);
    }
    
    public static function zaaImageUpload($ngModel, $label, array $options = [])
    {
        //return self::injector('zaa-table', $ngModel, $label, [], $options);
    }
    
    public static function zaaFileUpload($ngModel, $label, array $options = [])
    {
        //return self::injector('zaa-table', $ngModel, $label, [], $options);
    }
}