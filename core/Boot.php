<?php

namespace luya;

if (!version_compare(PHP_VERSION, '5.5.0', '>=')) {
    trigger_error('Some functions of luya need php version 5.5.0 or higher! You are currently using Version: '.PHP_VERSION, E_USER_ERROR);
}

/**
 * The LUYA boot class to startup the application
 * 
 * @author nadar
 */
class Boot extends \luya\base\Boot
{
}
