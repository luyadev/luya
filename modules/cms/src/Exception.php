<?php

namespace luya\cms;

/**
 * Exception wrapper for yii\base\Exception, represents a generic exception for all purposes.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
