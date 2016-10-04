<?php

namespace luya\cms;

/**
 * Exception wrapper for yii\base\Exception, represents a generic exception for all purposes.
 *
 * @author nadar
 * @since 1.0.0-beta5
 */
class Exception extends \luya\Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'CMS-Module Exception';
    }
}
