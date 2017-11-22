<?php

namespace luya\admin\base;

/**
 * TypesInterface represents all possible types for properties or blocks.
 *
 * The zaa types array are angular directives.
 *
 * + If a type contain `-array` the return is an array with selections
 * + Otherwise only 1 value can be returned
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface TypesInterface
{
    /**
     * @var string Type text represents a single row input field.
     */
    const TYPE_TEXT = 'zaa-text';
    
    /**
     * @var string Type textarea represents a multi row textarea input field.
     */
    const TYPE_TEXTAREA = 'zaa-textarea';
    
    /**
     * @var string Type password redpresents an input field which hiddes the input with type password.
     */
    const TYPE_PASSWORD = 'zaa-password';
    
    /**
     * @var string
     */
    const TYPE_NUMBER = 'zaa-number';
    
    /**
     * @var string
     */
    const TYPE_DECIMAL = 'zaa-decimal';
    
    /**
     * @var string The example out for the link type:
     *
     * ```php
     * ['type' => 2, 'value' => 'https://luya.io']
     * ```
     */
    const TYPE_LINK = 'zaa-link';
    
    /**
     * @var string Generates a Color-Wheel Input.
     */
    const TYPE_COLOR = 'zaa-color';
    
    /**
     * @var string
     */
    const TYPE_WYSIWYG = 'zaa-wysiwyg';
    
    /**
     * @var string Retuns the selected value from the options array. Where key is what will be stored and returned and value
     * will be display in the admin interfaces dropdown.
     */
    const TYPE_SELECT = 'zaa-select';
    
    /**
     * @var string Returns a list of radio inputs based on an options array, but allows only a selection of one. Therefore its
     * **not** `radios` or `radio-array` as the return value is not an array.
     */
    const TYPE_RADIO = 'zaa-radio';
    
    /**
     * @var string
     */
    const TYPE_DATE = 'zaa-date';
    
    /**
     * @var string
     */
    const TYPE_DATETIME = 'zaa-datetime';
    
    /**
     * @var integer If value is set (checkbox is checked) `1` will return otherwise `0`.
     */
    const TYPE_CHECKBOX = 'zaa-checkbox';
    
    /**
     * @var string
     */
    const TYPE_CHECKBOX_ARRAY = 'zaa-checkbox-array';
    
    /**
     * @var string
     */
    const TYPE_FILEUPLOAD = 'zaa-file-upload';
    
    /**
     * @var string
     */
    const TYPE_FILEUPLOAD_ARRAY = 'zaa-file-array-upload';
    
    /**
     * @var string
     */
    const TYPE_IMAGEUPLOAD = 'zaa-image-upload';
    
    /**
     * @var string
     */
    const TYPE_IMAGEUPLOAD_ARRAY = 'zaa-image-array-upload';
    
    /**
     * @var string The arrayable json output would be:
     *
     * ```php
     * [['value' => 1], ['value' => 2]]]
     * ```
     */
    const TYPE_LIST_ARRAY = 'zaa-list-array';
    
    /**
     * @var string Generates a table view similar to a json input.
     */
    const TYPE_TABLE = 'zaa-table';
    
    /**
     * @var string Generates a selection of all cms page, works only if cms module is present.
     */
    const TYPE_CMS_PAGE = 'zaa-cms-page';
    
    /**
     * @var string Generates a slugified input field which removes not valid url "link" chars like whitespaces.
     */
    const TYPE_SLUG = 'zaa-slug';

    /**
     * @var string Create an expandable list with plugins for each row.
     *
     * ```php
     * ['var' => 'people', 'label' => 'People', 'type' => self::TYPE_MULTIPLE_INPUTS, 'options' =>
     *     [
     *          [
     *              'type' => self::TYPE_SELECT,
     *              'var' => 'salutation',
     *              'label' => 'Salutation',
     *              'options' => [
     *                  ['value' => 1, 'label' => 'Mr.'],
     *                  ['value' => 2, 'label' => 'Mrs.'],
     *              ]
     *          ], [
     *              'type' => self::TYPE_TEXT,
     *              'var' => 'name',
     *              'label' => 'Name'
     *          ]
     *      ]
     * ]
     * ```
     */
    const TYPE_MULTIPLE_INPUTS = 'zaa-multiple-inputs';
    
    /**
     * @var string Generates a multi selection and sortable list and returns a json array with the selected values.
     */
    const TYPE_SORT_RELATION_ARRAY = 'zaa-sort-relation-array';
}
