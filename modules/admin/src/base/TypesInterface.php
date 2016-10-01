<?php

namespace luya\admin\base;

/**
 * TypesInterface represents all possible types for properties or blocks.
 * 
 * @author Basil Suter <basil@nadar.io>
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
     * @var string
     */
    const TYPE_LINK = 'zaa-link';
    
    /**
     * @var string
     */
    const TYPE_WYSIWYG = 'zaa-wysiwyg';
    
    /**
     * @var string
     */
    const TYPE_SELECT = 'zaa-select';
    
    /**
     * @var string
     */
    const TYPE_DATE = 'zaa-date';
    
    /**
     * @var string
     */
    const TYPE_DATETIME = 'zaa-datetime';
    
    /**
     * @var string
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
    const TYPE_FILEUPLOAD_ARRAY = 'zaa-file-upload-array';
    
    /**
     * @var string
     */
    const TYPE_IMAGEUPLOAD = 'zaa-image-upload';
    
    /**
     * @var string
     */
    const TYPE_IAGEUPLOAD_ARRAY = 'zaa-image-upload-array';
    
    /**
     * @var string
     */
    const TYPE_LIST_ARRAY = 'zaa-list-array';
}
