<?php

namespace luya\cms\helpers;

use Yii;

/**
 * Helper methods for CMS Blocks.
 *
 * As before those options has been stored in the {{\luya\cms\base\InternalBaseBlock}} they
 * are now located as static helper methods here.
 *
 * The helper methods are basically tasks you are using a lot when dealing with block extra
 * value output or configuration of a block element like vars, cfgs.
 *
 * @since 1.0.0-RC2
 * @author Basil Suter <basil@nadar.io>
 */
class BlockHelper
{
    /**
     * Create the options array for a zaa-select field based on an key value pairing
     * array.
     *
     * @param array $options The key value array pairing the select array should be created from.
     * @since 1.0.0-beta5
     */
    public static function selectArrayOption(array $options)
    {
        $transform = [];
        foreach ($options as $key => $value) {
            $transform[] = ['value' => $key, 'label' => $value];
        }
    
        return $transform;
    }
    
    /**
     * Create the Options list in the config for a zaa-checkbox-array based on an
     * key => value pairing array.
     *
     * @param array $options The array who cares the options with items
     * @since 1.0.0-beta5
     */
    public static function checkboxArrayOption(array $options)
    {
        $transform = [];
        foreach ($options as $key => $value) {
            $transform[] = ['value' => $key, 'label' => $value];
        }
    
        return ['items' => $transform];
    }
    
    /**
     * Get all informations from an zaa-image-upload type:
     *
     * ```php
     * 'image' => BlockHelper::ImageUpload($this->getVarValue('myImage')),
     * ```
     *
     * apply a filter for the image
     *
     * ```php
     * 'imageFiltered' => BlockHelper::ImageUpload($this->getVarValue('myImage'), 'small-thumbnail'),
     * ```
     *
     * @param string|int $value Provided the value
     * @param boolean|string $applyFilter To apply a filter insert the identifier of the filter.
     * @param boolean $returnObject Whether the storage object should be returned or an array.
     * @return boolean|array|luya\admin\image\Item Returns false when not found, returns an array with all data for the image on success.
     */
    public static function imageUpload($value, $applyFilter = false, $returnObject = false)
    {
        if (empty($value)) {
            return false;
        }
    
        $image = Yii::$app->storage->getImage($value);
    
        if (!$image) {
            return false;
        }
    
        if ($applyFilter && is_string($applyFilter)) {
            $filter = $image->applyFilter($applyFilter);
    
            if ($filter) {
                if ($returnObject) {
                    return $filter;
                }
                return $filter->toArray();
            }
        }
    
        if ($returnObject) {
            return $image;
        }
        return $image->toArray();
    }
    
    /**
     * Get the full array for the specific zaa-file-image-upload type
     *
     * ```php
     * 'imageList' => BlockHelper::ImageArrayUpload($this->getVarValue('images')),
     * ```
     *
     * Each array item will have all file query item data and a caption key.
     *
     * @param string|int $value The specific var or cfg fieldvalue.
     * @param boolean|string $applyFilter To apply a filter insert the identifier of the filter.
     * @param boolean $returnObject Whether the storage object should be returned or an array.
     * @return array Returns an array in any case, even an empty array.
     */
    public static function imageArrayUpload($value, $applyFilter = false, $returnObject = false)
    {
        if (!empty($value) && is_array($value)) {
            $data = [];
    
            foreach ($value as $key => $item) {
                $image = static::imageUpload($item['imageId'], $applyFilter, true);
                if ($image) {
                    $image->caption = $item['caption'];
    
                    $data[$key] = ($returnObject) ? $image : $image->toArray();
                }
            }
    
            return $data;
        }
    
        return [];
    }
    
    /**
     * Return all informations for a file if exists
     *
     * ```php
     * 'file' => BlockHelper::FileUpload($this->getVarValue('myFile')),
     * ```
     *
     * @param string|int $value Provided the value
     * @param boolean $returnObject Whether the storage object should be returned or an array.
     * @return boolean|array|\luya\admin\file\Item Returns false when not found, returns an array with all data for the image on success.
     */
    public static function fileUpload($value, $returnObject = false)
    {
        if (!empty($value)) {
            $file = Yii::$app->storage->getFile($value);
            /* @var \luya\admin\file\Item $file */
            if ($file) {
                if ($returnObject) {
                    return $file;
                }
                return $file->toArray();
            }
        }
    
        return false;
    }
    
    /**
     * Get the full array for the specific zaa-file-array-upload type
     *
     * ```php
     * 'fileList' => BlockHelper::FileArrayUpload($this->getVarValue('files')),
     * ```
     *
     * Each array item will have all file query item data and a caption key.
     *
     * @param string|int $value The specific var or cfg fieldvalue.
     * @param boolean $returnObject Whether the storage object should be returned or an array.
     * @return array Returns an array in any case, even an empty array.
     */
    public static function fileArrayUpload($value, $returnObject = false)
    {
        if (!empty($value) && is_array($value)) {
            $data = [];
            foreach ($value as $key => $item) {
                $file = static::fileUpload($item['fileId'], true);
                if ($file) {
                    if (!empty($item['caption'])) {
                        $file->caption = $item['caption'];
                    } else {
                        $file->caption = $file->name;
                    }
                    $data[$key] = ($returnObject) ? $file : $file->toArray();
                }
            }
    
            return $data;
        }
    
        return [];
    }
}
