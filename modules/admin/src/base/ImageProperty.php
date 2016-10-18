<?php

namespace luya\admin\base;

use Yii;

/**
 * Base Image Property.
 * 
 * This property overrides the default implementation of a property in order to simplify the integration of image property. The
 * response of the method `getValue()` is the **source** to the file. If no image is provided or it can not be loaded the
 * response is false.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
abstract class ImageProperty extends Property
{
    /**
     * Type Image
     * 
     * @see \luya\admin\base\Property::type()
     */
    public function type()
    {
        return self::TYPE_IMAGEUPLOAD;
    }
    
    /**
     * Get the source of the image, if not available the method returns false.
     * 
     * @return string|boolean Returns the path to the file, otherwise false.
     * @see \luya\admin\base\Property::getValue()
     */
    public function getValue()
    {
        $value = parent::getValue();
        
        if ($value) {
            $image = Yii::$app->storage->getImage($value);
            if ($image) {
                return $image->source;   
            }
        }
        
        return false;
    }
}