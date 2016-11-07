<?php

namespace luya;

/**
 * LUYA base exception.
 * 
 * Exception wrapper for yii\base\Exception, represents a generic exception for all purposes.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta3
 */
class Exception extends \yii\base\Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'LUYA Exception';
    }
}
