<?php

namespace luya;

/**
 * Exception wrapper for yii\base\Exception, represents a generic exception for all purposes.
 *
 * @author nadar
 * @since 1.0.0-beta3
 */
class Exception extends \yii\base\Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Luya Exception';
    }
}
